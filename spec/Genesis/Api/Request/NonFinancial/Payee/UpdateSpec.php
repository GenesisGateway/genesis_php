<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Update;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class UpdateSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Update::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(
            [
                'payee_unique_id'
            ]
        );
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setPayeeCountry', ['XX']);
    }

    public function it_should_successfully_validate_with_valid_parameters()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $payeeUniqueId = $this->getFaker()->uuid;
        $this->setPayeeUniqueId($payeeUniqueId);

        $this->getApiConfig('url')->shouldContain("payee/{$payeeUniqueId}");
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_PATCH);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_set_optional_parameters()
    {
        $this->setRequestParameters();
        $this->setPayeeDate('1990-01-01');
        $this->setPayeeNotificationUrl('https://example.com/notifications');
        $this->setPayeeRegistrationNumber($this->getFaker()->numerify('########'));
        $this->setAddressCity('London');
        $this->setAddressStreet('Test 12');
        $this->setAddressCountry('GB');
        $this->setAddressZipCode('1234');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function setRequestParameters()
    {
        $this->setPayeeUniqueId($this->getFaker()->uuid);
        $this->setPayeeName($this->getFaker()->name());
        $this->setPayeeCountry($this->getFaker()->randomElement(Country::getList()));
    }
}

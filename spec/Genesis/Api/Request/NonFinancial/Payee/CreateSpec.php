<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Create;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class CreateSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Create::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_company_missing_registration_number()
    {
        $this->setPayeeType('company');
        $this->setPayeeName($this->getFaker()->name());
        $this->setPayeeCountry($this->getFaker()->randomElement(Country::getList()));

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_successfully_validate_company_with_registration_number()
    {
        $this->setPayeeType('company');
        $this->setPayeeName($this->getFaker()->name());
        $this->setPayeeCountry($this->getFaker()->randomElement(Country::getList()));
        $this->setPayeeRegistrationNumber($this->getFaker()->numerify('########'));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_successfully_validate_person_without_registration_number()
    {
        $this->setPayeeType('person');
        $this->setPayeeName($this->getFaker()->name());
        $this->setPayeeCountry($this->getFaker()->randomElement(Country::getList()));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_set_optional_parameters()
    {
        $this->setRequestParameters();
        $this->setPayeeDate('1990-01-01');
        $this->setPayeeNotificationUrl('https://example.com/notifications');
        $this->setAddressCity('London');
        $this->setAddressStreet('Test 12');
        $this->setAddressCountry('GB');
        $this->setAddressZipCode('1234');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(
            [
                'payee_type',
                'payee_name',
                'payee_country'
            ]
        );
    }

    public function it_should_fail_with_invalid_payee_type()
    {
        $this->setRequestParameters();
        $this->setPayeeType('invalid_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->setRequestParameters();
        $this->setPayeeCountry('XX');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_successfully_validate_with_valid_data()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->setRequestParameters();

        $this->getApiConfig('url')->shouldBe('https://staging.api.emerchantpay.net:443/payee');
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_POST);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function setRequestParameters()
    {
        $payeeType = $this->getFaker()->randomElement(['company', 'person']);
        $this->setPayeeType($payeeType);
        $this->setPayeeName($this->getFaker()->name());
        $this->setPayeeCountry($this->getFaker()->randomElement(Country::getList()));

        if ($payeeType === 'company') {
            $this->setPayeeRegistrationNumber($this->getFaker()->numerify('########'));
        }
    }
}

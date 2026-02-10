<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Owners;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Constants\NonFinancial\Payee\OwnerTypes;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Owners\Create;
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

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(
            [
                'owner_type',
                'owner_name',
                'owner_country'
            ]
        );
    }

    public function it_should_work_with_only_required_parameters()
    {
        $this->setOwnerType(OwnerTypes::PERSON);
        $this->setOwnerName($this->getFaker()->company());
        $this->setOwnerCountry($this->getFaker()->randomElement(Country::getList()));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_invalid_owner_type()
    {
        $this->setRequestParameters();
        $this->setOwnerType('invalid_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_throw_without_registration_number_and_payee_type_company()
    {
        $this->setRequestParameters();
        $this->setOwnerType(OwnerTypes::COMPANY);
        $this->setOwnerRegistrationNumber(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->setRequestParameters();
        $this->setOwnerCountry('XX');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_successfully_validate_with_valid_data()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setRequestParameters();

        $this->getApiConfig('url')->shouldBe('https://staging.api.emerchantpay.net:443/payee/owners');
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
        $this->setOwnerType(OwnerTypes::PERSON);
        $this->setOwnerName($this->getFaker()->company());
        $this->setOwnerCountry($this->getFaker()->randomElement(Country::getList()));
        $this->setOwnerDate($this->getFaker()->date('Y-m-d'));
        $this->setOwnerNotificationUrl($this->getFaker()->url());
        $this->setAddressCity($this->getFaker()->city());
        $this->setAddressStreet($this->getFaker()->streetAddress());
        $this->setAddressState($this->getFaker()->state());
        $this->setAddressCountry($this->getFaker()->randomElement(Country::getList()));
        $this->setAddressZipCode($this->getFaker()->postcode());
        $this->setOwnerRegistrationNumber($this->getFaker()->numerify('##########'));
    }
}

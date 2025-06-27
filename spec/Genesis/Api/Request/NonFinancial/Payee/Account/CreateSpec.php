<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Account;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use Genesis\Api\Request\NonFinancial\Payee\Account\Create;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use Genesis\Exceptions\ErrorParameter;

class CreateSpec extends ObjectBehavior
{
    private $payee_unique_id;

    use RequestExamples;

    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Create::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(
            [
                'payee_unique_id',
                'payee_account_type',
                'payee_account_number'
            ]
        );
    }

    public function it_should_fail_with_invalid_account_type()
    {
        $this->setRequestParameters();
        $this->setPayeeAccountType('invalid_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->setRequestParameters();
        $this->setPayeeAccountCountry('XX');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_require_institution_code_when_bank_account_type()
    {
        $this->setRequestParameters();
        $this->setPayeeAccountType('bank');
        $this->setPayeeAccountInstitutionCode(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_require_institution_code_when_iban_account_type()
    {
        $this->setRequestParameters();
        $this->setPayeeAccountInstitutionCode(null);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_successfully_validate_with_valid_data()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_POST);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->setRequestParameters();

        $this->getApiConfig('url')->shouldContain("payee/{$this->payee_unique_id}/account");
    }

    public function setRequestParameters()
    {
        $this->payee_unique_id = $this->getFaker()->uuid;

        $this->setPayeeUniqueId($this->payee_unique_id);
        $this->setPayeeAccountType('iban');
        $this->setPayeeAccountNumber($this->getFaker()->iban);
        $this->setPayeeAccountCountry($this->getFaker()->randomElement(Country::getList()));
        $this->setPayeeAccountInstitutionCode($this->getFaker()->swiftBicNumber());
    }
}

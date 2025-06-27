<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Account;

use PhpSpec\ObjectBehavior;
use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Api\Request\NonFinancial\Payee\Account\ListAccounts;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class ListAccountsSpec extends ObjectBehavior
{
    private $payee_unique_id;

    use RequestExamples;

    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ListAccounts::class);
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

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_GET);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_build_correct_base_url()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->setRequestParameters();

        $this->getApiConfig('url')->shouldContain("payee/{$this->payee_unique_id}/account");
    }

    public function it_should_add_filters_to_url_when_provided()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->setRequestParameters();

        $this->setNumberEq('12345');
        $this->getApiConfig('url')->shouldContain("?number_eq=12345");

        $this->setTypeEq('bank');
        $this->getApiConfig('url')->shouldContain("&type_eq=bank");

        $this->setInstitutionCodeEq('ABCDEF');
        $this->getApiConfig('url')->shouldContain("&institution_code_eq=ABCDEF");
    }

    public function it_should_not_add_filters_when_null()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->setRequestParameters();

        $this->setNumberEq(null);
        $this->setTypeEq(null);
        $this->setInstitutionCodeEq(null);

        $this->getApiConfig('url')->shouldNotContain("?");
    }

    public function setRequestParameters()
    {
        $this->payee_unique_id = $this->getFaker()->uuid;
        $this->setPayeeUniqueId($this->payee_unique_id);
    }
}

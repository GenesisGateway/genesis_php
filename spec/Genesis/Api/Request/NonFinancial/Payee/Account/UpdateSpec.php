<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Account;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Account\Update;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class UpdateSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $payee_id;
    protected $account_id;

    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Update::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_successfully_validate_with_valid_data()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_update_request_path_correctly()
    {
        $this->setRequestParameters();
        $this->getApiConfig('url')->shouldContain($this->payee_id);
        $this->getApiConfig('url')->shouldContain($this->account_id);
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->setRequestParameters();

        $this->getApiConfig('url')->shouldContain("payee/{$this->payee_id}/account/{$this->account_id}");
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_PATCH);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->setRequestParameters();
        $this->setPayeeAccountCountry('XX');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function setRequestParameters()
    {
        $this->payee_id   = $this->getFaker()->uuid;
        $this->account_id = $this->getFaker()->uuid;

        $this->setPayeeUniqueId($this->payee_id);
        $this->setAccountUniqueId($this->account_id);
        $this->setPayeeAccountCountry($this->getFaker()->randomElement(Country::getList()));
    }
}

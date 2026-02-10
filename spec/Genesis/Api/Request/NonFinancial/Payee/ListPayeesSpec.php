<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\ListPayees;
use Genesis\Builder;
use Genesis\Config;
use PhpSpec\ObjectBehavior;

class ListPayeesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ListPayees::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_successfully_validate_without_parameters()
    {
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_can_build_structure()
    {
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->getApiConfig('url')->shouldBe('https://staging.api.emerchantpay.net:443/payee');
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_GET);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}

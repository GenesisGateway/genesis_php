<?php

namespace spec\Genesis\Api;

use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('\Genesis\Api\Request\NonFinancial\Blacklist');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('\Genesis\Api\Request\NonFinancial\Blacklist');
    }

    public function it_can_set_variables()
    {
        $this->setCardNumber('420000');

        $this->getCardNumber()->shouldBe('420000');

        $this->getDocument()->shouldContain('420000');
    }

    public function it_cant_set_unknown_variables()
    {
        $this
            ->shouldThrow('\Genesis\Exceptions\InvalidMethod')
            ->during('setUnknownProperty', [ true ]);

        $this
            ->shouldThrow('\Genesis\Exceptions\InvalidMethod')
            ->during('getUnownProperty');
    }

    public function it_can_get_api_configs()
    {
        $this->getApiConfig('protocol')->shouldBe('https');
    }

    public function it_should_create_document()
    {
        $this->setCardNumber('420000');

        $this->shouldNotThrow()->during('getDocument');

        $this->getDocument()->shouldContain('420000');
    }

    public function it_should_have_default_environment_url_for_ecp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING
        );

        $this->getApiConfig('url')->shouldBe('https://staging.gate.e-comprocessing.net:443/blacklists');
    }

    public function it_should_have_default_environment_url_for_emp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/blacklists');
    }

    public function getMatchers(): array
    {
        return array(
            'contain' => function ($subject, $arg) {
                return (stripos($subject, $arg) !== false);
            },
        );
    }
}

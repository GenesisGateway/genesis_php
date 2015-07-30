<?php

namespace spec\Genesis\API;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('\Genesis\API\Request\NonFinancial\Blacklist');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('\Genesis\API\Request\NonFinancial\Blacklist');
    }

    function it_can_set_variables()
    {
        $this->setCardNumber('420000');

        $this->getCardNumber()->shouldBe('420000');

        $this->getDocument()->shouldContain('420000');
    }

    function it_cant_set_unknown_variables()
    {
        $this->setUnknownProperty(true)->shouldBe($this);

        $this->getUnownProperty()->shouldBe($this);
    }

    function it_can_get_api_configs()
    {
        $this->getApiConfig('protocol')->shouldBe('https');
    }

    function it_should_create_document()
    {
        $this->setCardNumber('420000');

        $this->shouldNotThrow()->during('getDocument');

        $this->getDocument()->shouldContain('420000');
    }

    function it_should_have_default_environment_url_for_ecp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this->getApiConfig('url')->shouldBe('https://staging.gate.e-comprocessing.net:443/blacklists');
    }

    function it_should_have_default_environment_url_for_emp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/blacklists');
    }

    public function getMatchers()
    {
        return array(
            'contain' => function ($subject, $arg) {
                return (stripos($subject, $arg) !== false);
            },
        );
    }
}

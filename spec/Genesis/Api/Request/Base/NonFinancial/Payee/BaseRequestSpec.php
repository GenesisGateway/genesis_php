<?php

namespace spec\Genesis\Api\Request\Base\NonFinancial\Payee;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\Request\NonFinancial\Payee\BaseRequestStub;

class BaseRequestSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BaseRequestStub::class);
    }

    public function it_should_initialize_configuration_properly()
    {
        $this->shouldNotThrow()->during('initConfiguration');
    }

    public function it_should_set_get_request_configuration()
    {
        $this->setGetRequest();
        $config = $this->config;
        $config->shouldHaveKey('protocol');
        $config->shouldHaveKey('port');
        $config->shouldHaveKey('type');
        $config->shouldHaveKey('format');
        $config->shouldHaveKey('authorization');
    }
}

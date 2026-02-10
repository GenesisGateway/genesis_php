<?php

namespace spec\Genesis\Api\Request\NonFinancial\ManagedRecurring;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\NonFinancial\ManagedRecurring\Items;
use Genesis\Builder;
use Genesis\Config;
use PhpSpec\ObjectBehavior;

class ItemsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(Items::class);
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/v1/managed_recurring/items');
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_GET);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }
}

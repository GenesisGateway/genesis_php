<?php

namespace spec\Genesis\Api\Request\NonFinancial\Fx;

use Genesis\Api\Request;
use Genesis\Api\Request\NonFinancial\Fx\GetTiers;
use Genesis\Builder;
use PhpSpec\ObjectBehavior;

class GetTiersSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(GetTiers::class);
    }

    public function it_should_build_correct_url()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/v1/fx/tiers');
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

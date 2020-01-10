<?php

namespace spec\Genesis\API\Request\NonFinancial\Fx;

use Genesis\API\Request;
use Genesis\API\Request\NonFinancial\Fx\GetRates;
use Genesis\Builder;
use PhpSpec\ObjectBehavior;

class GetRatesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(GetRates::class);
    }

    public function it_should_build_correct_url()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );
        $this->setTierId(88);

        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/v1/fx/tiers/88/rates');
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

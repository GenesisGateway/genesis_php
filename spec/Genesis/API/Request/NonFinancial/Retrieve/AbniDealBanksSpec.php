<?php

namespace spec\Genesis\API\Request\NonFinancial\Retrieve;

use Genesis\API\Request\NonFinancial\Retrieve\AbniDealBanks;
use PhpSpec\ObjectBehavior;

class AbniDealBanksSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(AbniDealBanks::class);
    }

    public function it_should_build_correct_url_for_ecp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this->getApiConfig('url')->shouldBe('https://staging.gate.e-comprocessing.net:443/retrieve_abn_ideal_banks');
    }

    public function it_should_build_correct_url_for_emp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/retrieve_abn_ideal_banks');
    }
}

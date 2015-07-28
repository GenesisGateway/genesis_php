<?php

namespace spec\Genesis\API\Request\NonFinancial\Retrieve;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AbniDealBanksSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\NonFinancial\Retrieve\AbniDealBanks');
    }

    function it_should_build_without_parameters()
    {
        $this->shouldNotThrow()->during('getDocument');
    }

    function it_should_build_empty_body()
    {
        $this->Build();
        $this->getDocument()->shouldBeNull();
    }

    function it_should_build_correct_url()
    {
        $this->getApiConfig('url')->shouldBe('https://staging.gate.e-comprocessing.net:443/retrieve_abn_ideal_banks');
    }
}

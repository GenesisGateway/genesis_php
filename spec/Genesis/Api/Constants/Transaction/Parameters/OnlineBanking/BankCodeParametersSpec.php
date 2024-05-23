<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\OnlineBanking;

use Genesis\Api\Constants\Transaction\Parameters\OnlineBanking\BankCodeParameters;
use PhpSpec\ObjectBehavior;

class BankCodeParametersSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BankCodeParameters::class);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BankCodeParameters::class);
    }

    public function it_should_be_array_with_currencies()
    {
        $this->getAllowedCurrencies()->shouldBeArray();
    }

    public function it_should_be_not_empty_array_with_currencies()
    {
        $this->getAllowedCurrencies()->shouldNotBe([]);
    }

    public function it_should_be_array_for_every_allowed_currency()
    {
        $currencies = BankCodeParameters::getAllowedCurrencies();

        foreach($currencies as $currency) {
            $this->getBankCodesPerCurrency($currency)->shouldBeArray();
        }
    }
}

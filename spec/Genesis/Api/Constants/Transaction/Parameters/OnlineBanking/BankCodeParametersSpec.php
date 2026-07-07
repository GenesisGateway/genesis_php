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

    public function it_should_return_empty_array_for_null_currency()
    {
        $this->getBankCodesPerCurrency(null)->shouldBe([]);
    }

    public function it_should_not_trigger_deprecation_for_null_currency()
    {
        $deprecations = array();
        set_error_handler(function ($errno, $errstr) use (&$deprecations) {
            $deprecations[] = $errstr;
        }, E_DEPRECATED | E_USER_DEPRECATED);

        BankCodeParameters::getBankCodesPerCurrency(null);

        restore_error_handler();

        if (!empty($deprecations)) {
            throw new \Exception(
                'Deprecation notice triggered: ' . implode('; ', $deprecations)
            );
        }
    }
}

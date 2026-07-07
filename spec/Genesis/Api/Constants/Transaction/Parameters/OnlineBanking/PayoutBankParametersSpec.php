<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\OnlineBanking;

use Genesis\Api\Constants\Transaction\Parameters\OnlineBanking\PayoutBankParameters;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

/**
 * Class PayoutBankParametersSpec
 * @package spec\Genesis\Api\Constants\Transaction\Parameters\OnlineBanking
 */
class PayoutBankParametersSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PayoutBankParameters::class);
    }

    public function it_should_be_array_allowed_currencies()
    {
        $this->getAllowedCurrencies()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_allowed_currencies()
    {
        $this->getAllowedCurrencies()->shouldNotBeEqualTo([]);
    }

    public function it_should_be_array_bank_names_per_currency()
    {
        $faker    = Faker::getInstance();
        $currency = $faker->randomElement(PayoutBankParameters::getAllowedCurrencies());

        $this->getbankNamesPerCurrency($currency)->shouldBeArray();
    }

    public function it_should_return_empty_array_for_null_currency()
    {
        $this->getBankNamesPerCurrency(null)->shouldBe([]);
    }

    public function it_should_not_trigger_deprecation_for_null_currency()
    {
        $deprecations = array();
        set_error_handler(function ($errno, $errstr) use (&$deprecations) {
            $deprecations[] = $errstr;
        }, E_DEPRECATED | E_USER_DEPRECATED);

        PayoutBankParameters::getBankNamesPerCurrency(null);

        restore_error_handler();

        if (!empty($deprecations)) {
            throw new \Exception(
                'Deprecation notice triggered: ' . implode('; ', $deprecations)
            );
        }
    }
}

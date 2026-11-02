<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Wallets\EWallet;

use Genesis\Api\Constants\Transaction\Parameters\Wallets\EWallet\PaymentTypes;
use PhpSpec\ObjectBehavior;

class PaymentTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PaymentTypes::class);
    }

    public function it_should_be_array_allowed_payment_types()
    {
        $this::getAllowedPaymentTypes()->shouldBeArray();
    }

    // Feature: add-ewallet-transaction-support, Property 14: Provider constants match the gateway values exactly
    // For any value returned by PaymentTypes::getAllowedPaymentTypes(), the value is a member of the exact set
    // {Airtel Money, Amazon pay, Free Charge, Jio Money, Ola Money, Paytm, Payzapp, PhonePe}, and the returned
    // array contains all eight of them.
    public function it_should_return_the_exact_allowed_payment_types()
    {
        $allowed  = array_values(PaymentTypes::getAllowedPaymentTypes());
        $expected = $this->expectedPaymentTypes();

        // full enumeration, soundness half: every returned value belongs to the expected set
        foreach ($allowed as $paymentType) {
            if (!in_array($paymentType, $expected, true)) {
                throw new \Exception("Unexpected allowed payment type: {$paymentType}");
            }
        }

        // full enumeration, completeness half: every expected value is returned
        foreach ($expected as $paymentType) {
            if (!in_array($paymentType, $allowed, true)) {
                throw new \Exception("Missing allowed payment type: {$paymentType}");
            }
        }

        $this::getAllowedPaymentTypes()->shouldHaveCount(count($expected));
    }

    /**
     * The exact gateway provider values, verbatim casing
     *
     * @return array
     */
    private function expectedPaymentTypes()
    {
        return [
            'Airtel Money',
            'Amazon pay',
            'Free Charge',
            'Jio Money',
            'Ola Money',
            'Paytm',
            'Payzapp',
            'PhonePe'
        ];
    }
}

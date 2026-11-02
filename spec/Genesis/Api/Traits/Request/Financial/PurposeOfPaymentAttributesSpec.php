<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\Payout\MoneyTransferPurposeOfPayment;
use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPayment;
use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPaymentValues;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\PurposeOfPaymentAttributesStub;

class PurposeOfPaymentAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PurposeOfPaymentAttributesStub::class);
    }

    public function it_should_accept_a_visa_code()
    {
        $this->setPurposeOfPayment(PurposeOfPayment::ISBONU)->shouldReturn($this);
        $this->getPurposeOfPayment()->shouldBe(PurposeOfPayment::ISBONU);
    }

    public function it_should_accept_a_visa_value()
    {
        $this->setPurposeOfPayment(PurposeOfPaymentValues::BONUS_PAYMENT)->shouldReturn($this);
        $this->getPurposeOfPayment()->shouldBe(PurposeOfPaymentValues::BONUS_PAYMENT);
    }

    public function it_should_name_the_parameter_when_rejecting_a_value()
    {
        $this->shouldThrow(
            new InvalidArgument(
                'Parameter Purpose of Payment not valid! Allowed values are ' .
                implode(', ', array_merge(PurposeOfPayment::getCodes(), PurposeOfPaymentValues::getAll()))
            )
        )->during('setPurposeOfPayment', ['INVALID']);
    }

    public function it_should_reject_a_money_transfer_only_value()
    {
        $this->setPurposeOfPayment(PurposeOfPayment::ISINTE);

        $this->shouldThrow(InvalidArgument::class)->during(
            'setPurposeOfPayment',
            [MoneyTransferPurposeOfPayment::FAMILY_SUPPORT]
        );
        $this->getPurposeOfPayment()->shouldBe(PurposeOfPayment::ISINTE);
    }
}

<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Payout;

use Genesis\Api\Constants\Transaction\Parameters\Payout\MoneyTransferPurposeOfPayment;
use PhpSpec\ObjectBehavior;

/**
 * Class MoneyTransferPurposeOfPaymentSpec
 *
 * @package spec\Genesis\Api\Constants\Transaction\Parameters\Payout
 */
class MoneyTransferPurposeOfPaymentSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MoneyTransferPurposeOfPayment::class);
    }

    public function it_should_be_array_get_all()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_get_all()
    {
        $this->getAll()->shouldNotBeEqualTo([]);
    }
}

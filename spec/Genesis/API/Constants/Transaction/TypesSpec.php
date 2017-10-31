<?php

namespace spec\Genesis\API\Constants\Transaction;

use Genesis\API\Constants\Transaction\Types;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Transaction\Types');
    }

    public function it_can_validate_transaction_types()
    {
        $this->isValidTransactionType(Types::SALE)->shouldReturn(true);
        $this->isValidTransactionType('non-existing-trx-type')->shouldReturn(false);
    }

    public function it_can_detect_supported_wpf_trx_types()
    {
        $this->isValidWPFTransactionType(Types::EZEEWALLET)->shouldReturn(true);
        $this->isValidWPFTransactionType(Types::IDEBIT_PAYIN)->shouldReturn(true);
    }

    public function it_can_detect_not_supported_wpf_trx_types()
    {
        $this->isValidWPFTransactionType(Types::EARTHPORT)->shouldReturn(false);
    }

    public function it_can_validate_pay_by_voucher_transaction_types()
    {
        $this->isPayByVoucher(Types::PAYBYVOUCHER_YEEPAY)->shouldReturn(true);
        $this->isPayByVoucher(Types::PAYBYVOUCHER_SALE)->shouldReturn(true);
        $this->isPayByVoucher(Types::EARTHPORT)->shouldReturn(false);
    }

    public function it_can_detect_3d_transaction_types()
    {
        $this->is3D(Types::SALE_3D)->shouldReturn(true);
        $this->is3D(Types::SALE)->shouldReturn(false);
        $this->is3D('test_3d_fake')->shouldReturn(false);
    }
}

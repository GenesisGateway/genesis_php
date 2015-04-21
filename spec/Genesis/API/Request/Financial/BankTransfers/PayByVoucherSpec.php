<?php

namespace spec\Genesis\API\Request\Financial\BankTransfers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PayByVoucherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\BankTransfers\PayByVoucher');
    }
}

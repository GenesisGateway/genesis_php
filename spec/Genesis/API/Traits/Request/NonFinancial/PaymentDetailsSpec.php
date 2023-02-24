<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\KYC\CVVPresents;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\PaymentDetailsStub;

class PaymentDetailsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PaymentDetailsStub::class);
    }

    public function it_should_set_bin_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBin',
            ['411111']
        );
    }

    public function it_should_fail_when_bin_is_invalid()
    {
        $this->shouldThrow()->during(
            'setBin',
            [88]
        );
    }

    public function it_should_set_tail_correctly()
    {
        $this->shouldNotThrow()->during(
            'setTail',
            ['1111']
        );
    }

    public function it_should_fail_when_tail_is_invalid()
    {
        $this->shouldThrow()->during(
            'setTail',
            [234]
        );
    }

    public function it_should_set_account_correctly()
    {
        $this->shouldNotThrow()->during(
            'setAccount',
            ['411111']
        );
    }

    public function it_should_fail_when_account_is_invalid()
    {
        $this->shouldThrow()->during(
            'setAccount',
            ['']
        );
        $this->shouldThrow()->during(
            'setAccount',
            [str_repeat('R', 31)]
        );
    }

    public function it_should_set_cvv_present_correctly()
    {
        $allowed = CVVPresents::getAll();

        foreach ($allowed AS $cvvPresent) {
            $this->shouldNotThrow()->during(
                'setCvvPresent',
                [$cvvPresent]
            );
        }
    }

    public function it_should_fail_when_cvv_present_is_invalid()
    {
        $this->shouldThrow()->during(
            'setCvvPresent',
            ['maybe']
        );
    }
}

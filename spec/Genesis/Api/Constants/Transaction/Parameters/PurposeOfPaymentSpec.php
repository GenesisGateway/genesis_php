<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPayment;
use PhpSpec\ObjectBehavior;

/**
 * Class PurposeOfPaymentSpec
 *
 * @package spec\Genesis\Api\Constants\Transaction\Parameters
 */
class PurposeOfPaymentSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PurposeOfPayment::class);
    }

    public function it_should_be_array_get_codes()
    {
        $this->getCodes()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_get_codes()
    {
        $this->getCodes()->shouldNotBeEqualTo([]);
    }

    public function it_should_contain_visa_codes()
    {
        $this->getCodes()->shouldContain(PurposeOfPayment::ISBONU);
        $this->getCodes()->shouldContain(PurposeOfPayment::ISSAVG);
    }
}

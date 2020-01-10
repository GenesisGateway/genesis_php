<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\FxRateAttributesStub;

class FxRateAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(FxRateAttributesStub::class);
    }

    public function it_should_be_int_fx_rate_id()
    {
        $this->setFxRateId('123');
        $this->getFxRateId()->shouldBeInt();
    }

    public function it_should_return_correct_value_fx_rate_id()
    {
        $this->setFxRateId('1234567');
        $this->getFxRateId()->shouldReturn(1234567);

        $this->setFxRateid(1234567);
        $this->getFxRateId()->shouldReturn(1234567);
    }
}

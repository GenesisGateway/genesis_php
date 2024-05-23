<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\ScaExemptions;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class ScaAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Genesis\Api\Stubs\Traits\Request\Financial\ScaAttributesStub');
    }

    public function it_should_not_fail_when_valid_exemption()
    {
        foreach(ScaExemptions::getAll() as $value) {
            $this->shouldNotThrow()->duringSetScaExemption($value);
        }
    }

    public function it_should_fail_when_invalid_exemption()
    {
        $this->shouldThrow(ErrorParameter::class)
            ->duringSetScaExemption('ttttt');
    }
}

<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;

class BankAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Genesis\Api\Stubs\Traits\Request\Financial\BankAttributesStub');
    }

    public function it_should_set_bic_correctly()
    {
        $allowedBicSizes = $this->object->getWrappedObject()->getAllowedBicSizes();

        foreach ($allowedBicSizes AS $size) {
            $this->shouldNotThrow()->during(
                'setBic',
                [str_repeat('8', $size)]
            );
        }
    }

    public function it_should_fail_bic_is_invalid()
    {
        $this->shouldThrow()->during(
            'setBic',
            [str_repeat('8', 99)]
        );
    }

    public function it_should_allow_null_value_bic()
    {
        $this->shouldNotThrow()->during('setBic', [null]);
    }
}

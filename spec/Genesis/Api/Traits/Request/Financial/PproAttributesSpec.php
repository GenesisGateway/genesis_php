<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;

class PproAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Genesis\Api\Stubs\Traits\Request\Financial\PproAttributesStub');
    }

    public function it_should_set_consumer_reference_correctly()
    {
        $this->shouldNotThrow()->during(
            'setConsumerReference',
            [str_repeat('8', $this->object->getWrappedObject()->getMaxConsumerReferenceLen())]
        );
    }

    public function it_should_set_national_id_correctly()
    {
        $this->shouldNotThrow()->during(
            'setNationalId',
            [str_repeat('8', $this->object->getWrappedObject()->getNationalIdLen())]
        );
    }

    public function it_should_fail_when_consumer_reference_is_invalid()
    {
        $this->shouldThrow()->during(
            'setConsumerReference',
            [str_repeat('8', $this->object->getWrappedObject()->getMaxConsumerReferenceLen() + 1)]
        );
    }

    public function it_should_fail_when_national_id_is_invalid()
    {
        $this->shouldThrow()->during(
            'setNationalId',
            [str_repeat('8', $this->object->getWrappedObject()->getNationalIdLen() + 1)]
        );
    }
}

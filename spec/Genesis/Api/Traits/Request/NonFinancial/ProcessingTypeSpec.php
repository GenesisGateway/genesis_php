<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Fraud\Chargeback\ProcessingTypes;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\ProcessingTypeStub;

class ProcessingTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ProcessingTypeStub::class);
    }

    public function it_should_fail_with_unproper_value()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setProcessingType', ['ttt']);
    }

    public function it_should_not_fail_with_proper_value()
    {
        $this->shouldNotThrow(InvalidArgument::class)->during(
            'setProcessingType', [$this->getRandomProcessingType()]
        );
    }

    private function getRandomProcessingType()
    {
        $processingTypes = ProcessingTypes::getAll();
        return $processingTypes[array_rand($processingTypes)];
    }
}

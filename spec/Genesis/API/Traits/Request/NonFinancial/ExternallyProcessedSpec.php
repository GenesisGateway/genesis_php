<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ExternallyProcessed;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\ExternallyProcessedStub;

class ExternallyProcessedSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ExternallyProcessedStub::class);
    }

    public function it_should_fail_with_unproper_value()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setExternallyProcessed', ['ttt']);
    }

    public function it_should_not_fail_proper_value()
    {
        $this->shouldNotThrow(InvalidArgument::class)->during(
            'setExternallyProcessed', [$this->getRandomExternallyProcessed()]
        );
    }

    private function getRandomExternallyProcessed()
    {
        $externallyProcessed = ExternallyProcessed::getAll();
        return $externallyProcessed[array_rand($externallyProcessed)];
    }
}

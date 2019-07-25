<?php

namespace spec\Genesis\API\Request\NonFinancial;

use Genesis\API as API;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class BlacklistSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(API\Request\NonFinancial\Blacklist::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'card_number'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setCardNumber($this->getFaker()->creditCardNumber);
    }
}

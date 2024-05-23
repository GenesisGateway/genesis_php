<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\GetCard;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\TokenizationApi\ParametersExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class GetCardSpec extends ObjectBehavior
{
    use ParametersExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(GetCard::class);
    }
}

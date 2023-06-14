<?php

namespace spec\Genesis\API\Request\NonFinancial\TokenizationApi;

use Genesis\API\Request\NonFinancial\TokenizationApi\Detokenize;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\TokenizationApi\ParametersExamples;

class DetokenizeSpec extends ObjectBehavior
{
    use RequestExamples, ParametersExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Detokenize::class);
    }

}

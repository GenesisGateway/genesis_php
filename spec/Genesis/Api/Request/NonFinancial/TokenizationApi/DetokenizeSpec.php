<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\Detokenize;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\TokenizationApi\ParametersExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class DetokenizeSpec extends ObjectBehavior
{
    use ParametersExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Detokenize::class);
    }

}

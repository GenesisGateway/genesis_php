<?php

namespace spec\Genesis\API\Request\NonFinancial\TokenizationApi;

use Genesis\API\Request\NonFinancial\TokenizationApi\ValidateToken;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\TokenizationApi\ParametersExamples;

class ValidateTokenSpec extends ObjectBehavior
{
    use RequestExamples, ParametersExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(ValidateToken::class);
    }
}

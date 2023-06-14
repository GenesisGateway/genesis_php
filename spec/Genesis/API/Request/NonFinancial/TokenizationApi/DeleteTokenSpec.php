<?php

namespace spec\Genesis\API\Request\NonFinancial\TokenizationApi;

use Genesis\API\Request\NonFinancial\TokenizationApi\DeleteToken;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\TokenizationApi\ParametersExamples;

class DeleteTokenSpec extends ObjectBehavior
{
    use RequestExamples, ParametersExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DeleteToken::class);
    }
}

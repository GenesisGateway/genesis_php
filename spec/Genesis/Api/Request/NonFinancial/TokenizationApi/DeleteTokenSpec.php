<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\DeleteToken;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\TokenizationApi\ParametersExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class DeleteTokenSpec extends ObjectBehavior
{
    use ParametersExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DeleteToken::class);
    }
}

<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use spec\SharedExamples\Faker;

trait AsyncAttributesExample
{
    public function it_should_accept_valid_url_for_return_success_url()
    {
        $this->shouldNotThrow()->during('setReturnSuccessUrl',
            [Faker::getInstance()->url()]
        );
    }

    public function it_should_return_string_for_return_success_url()
    {
        $this->setReturnSuccessUrl(Faker::getInstance()->url())
            ->getReturnSuccessUrl()->shouldBeString();
    }

    public function it_should_not_fail_with_null_value_for_return_success_url()
    {
        $this->shouldNotThrow()->during('setReturnSuccessUrl', [null]);
    }


    public function it_should_accept_valid_url_for_return_failure_url()
    {
        $this->shouldNotThrow()->during('setReturnFailureUrl',
            [Faker::getInstance()->url()]
        );
    }

    public function it_should_return_string_for_return_failure_url()
    {
        $this->setReturnFailureUrl(Faker::getInstance()->url())
            ->getReturnFailureUrl()->shouldBeString();
    }

    public function it_should_not_fail_with_null_value_for_return_failure_url()
    {
        $this->shouldNotThrow()->during('setReturnFailureUrl', [null]);
    }
}

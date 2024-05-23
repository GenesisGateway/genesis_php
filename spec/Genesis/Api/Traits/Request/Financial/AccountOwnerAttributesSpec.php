<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\AccountOwnerAttributesStub;
use spec\SharedExamples\Faker;

class AccountOwnerAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(AccountOwnerAttributesStub::class);
    }

    public function it_should_set_account_first_name()
    {
        $this->shouldNotThrow()->during(
            'setAccountFirstName',
            [Faker::getInstance()->firstName()]
        );
    }

    public function it_should_set_account_middle_name()
    {
        $this->shouldNotThrow()->during(
            'setAccountMiddleName',
            [Faker::getInstance()->lastName()]
        );
    }

    public function it_should_set_account_last_name()
    {
        $this->shouldNotThrow()->during(
            'setAccountLastName',
            [Faker::getInstance()->lastName()]
        );
    }
}

<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Api\Constants\Transaction\Parameters\CredentialOnFile;
use PhpSpec\ObjectBehavior;

class CredentialOnFileSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CredentialOnFile::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}

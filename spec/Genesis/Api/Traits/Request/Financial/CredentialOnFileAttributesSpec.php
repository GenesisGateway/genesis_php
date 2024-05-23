<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\CredentialOnFile;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\CredentialOnFileAttributesStub;
use spec\SharedExamples\Faker;

class CredentialOnFileAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CredentialOnFileAttributesStub::class);
    }

    public function it_should_have_array_structure()
    {
        $this->returnCredentialOnFileAttributesStructure()->shouldBeArray();
    }

    public function it_should_have_correct_structure()
    {
        $this->returnCredentialOnFileAttributesStructure()->shouldHaveKeyWithValue(
            'credential_on_file',
            null
        );
    }

    public function it_should_fail_with_invalid_cof_indicator()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCredentialOnFile',
            ['invalid']
        );
    }

    public function it_should_not_fail_when_unset_cof_attribute()
    {
        $this->shouldNotThrow()->during(
            'setCredentialOnFile',
            [null]
        );
        $this->getCredentialOnFile()->shouldBeNull();
    }

    public function it_should_not_fail_with_valid_cof_indicator()
    {
        $this->shouldNotThrow()->during(
            'setCredentialOnFile',
            [Faker::getInstance()->randomElement(CredentialOnFile::getAll())]
        );
    }
}

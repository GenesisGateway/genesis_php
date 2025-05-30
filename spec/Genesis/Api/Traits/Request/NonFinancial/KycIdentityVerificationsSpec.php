<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\KycIdentityVerificationsStub;
use spec\SharedExamples\Faker;

class KycIdentityVerificationsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycIdentityVerificationsStub::class);
    }

    public function it_should_set_proof_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentProof',
            [Faker::getInstance()->word()]
        );
    }

    public function it_should_set_date_of_birth_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentDateOfBirth',
            [Faker::getInstance()->date('Y-m-d')]
        );

        $this->shouldNotThrow()->during(
            'setDocumentDateOfBirth',
            ['']
        );
    }

    public function it_should_unset_date_of_birth()
    {
        $this->setDocumentDateOfBirth(null)->shouldReturn($this);
        $this->getDocumentDateOfBirth()->shouldBeNull();
    }

    public function it_should_set_first_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentFirstName',
            [Faker::getInstance()->firstName()]
        );
    }

    public function it_should_not_fail_with_empty_first_name()
    {
        $this->shouldNotThrow()->during(
            'setDocumentFirstName',
            ['']
        );

        $this->shouldNotThrow()->during(
            'setDocumentFirstName',
            [null]
        );
    }

    public function it_should_set_middle_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentMiddleName',
            [Faker::getInstance()->firstName()]
        );
    }

    public function it_should_not_fail_with_empty_middle_name()
    {
        $this->shouldNotThrow()->during(
            'setDocumentMiddleName',
            ['']
        );

        $this->shouldNotThrow()->during(
            'setDocumentMiddleName',
            [null]
        );
    }

    public function it_should_set_last_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentLastName',
            [Faker::getInstance()->lastName()]
        );
    }

    public function it_should_not_fail_with_empty_last_name()
    {
        $this->shouldNotThrow()->during(
            'setDocumentLastName',
            ['']
        );

        $this->shouldNotThrow()->during(
            'setDocumentLastName',
            [null]
        );
    }

    public function it_should_set_full_address_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentFullAddress',
            [Faker::getInstance()->streetAddress()]
        );
    }

    public function it_should_not_fail_with_empty_full_address()
    {
        $this->shouldNotThrow()->during(
            'setDocumentFullAddress',
            ['']
        );

        $this->shouldNotThrow()->during(
            'setDocumentFullAddress',
            [null]
        );
    }

    public function it_should_fail_with_invalid_first_name()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setDocumentFirstName',
            [Faker::getInstance()->regexify('[A-Za-z]{33}')]
        );
    }

    public function it_should_fail_with_invalid_middle_name()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setDocumentMiddleName',
            [Faker::getInstance()->regexify('[A-Za-z]{33}')]
        );
    }

    public function it_should_fail_with_invalid_last_name()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setDocumentLastName',
            [Faker::getInstance()->regexify('[A-Za-z]{33}')]
        );
    }

    public function it_should_fail_with_invalid_full_address()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setDocumentLastName',
            [Faker::getInstance()->regexify('[A-Za-z]{251}')]
        );
    }
}

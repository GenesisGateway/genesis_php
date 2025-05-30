<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\KycDocumentVerificationsStub;
use spec\SharedExamples\Faker;

class KycDocumentVerificationsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycDocumentVerificationsStub::class);
    }

    public function it_should_set_first_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentFirstName',
            [Faker::getInstance()->firstName()]
        );
    }

    public function it_should_set_last_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentLastName',
            [Faker::getInstance()->lastName()]
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

    public function it_should_set_allow_online_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentAllowOnline',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setDocumentAllowOnline',
            [1]
        );
    }

    public function it_should_set_allow_offline_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentAllowOffline',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setDocumentAllowOffline',
            [1]
        );
    }
}

<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\KycFaceVerificationsStub;
use spec\SharedExamples\Faker;

class KycFaceVerificationsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycFaceVerificationsStub::class);
    }

    public function it_should_set_allow_online_correctly()
    {
        $this->shouldNotThrow()->during(
            'setFaceAllowOnline',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setFaceAllowOnline',
            [1]
        );
    }

    public function it_should_set_allow_offline_correctly()
    {
        $this->shouldNotThrow()->during(
            'setFaceAllowOffline',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setFaceAllowOffline',
            [1]
        );
    }

    public function it_should_set_face_check_duplicate_correctly()
    {
        $this->shouldNotThrow()->during(
            'setFaceCheckDuplicateRequest',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setFaceCheckDuplicateRequest',
            [1]
        );
    }
}

<?php

namespace spec\Genesis\Utils\Threeds;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\Utils\Threeds\V2;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class V2Spec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(V2::class);
    }

    public function it_should_generate_correct_threeds_signature()
    {
        $uniqueId         = Faker::getInstance()->uuid;
        $amount           = 10.00;
        $timestamp        = Faker::getInstance()->dateTime()->format(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU);
        $merchantPassword = 'password';

        $signature = hash(
            'sha512',
            $uniqueId . $amount . $timestamp . $merchantPassword,
            false
        );

        $this::generateSignature(
            $uniqueId,
            $amount,
            $timestamp,
            $merchantPassword
        )->shouldBe($signature);
    }
}

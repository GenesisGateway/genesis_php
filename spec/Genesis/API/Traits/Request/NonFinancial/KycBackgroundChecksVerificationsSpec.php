<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\KycBackgroundChecksVerificationsStub;
use spec\SharedExamples\Faker;

class KycBackgroundChecksVerificationsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycBackgroundChecksVerificationsStub::class);
    }

    public function it_should_set_first_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksFirstName',
            [Faker::getInstance()->firstName()]
        );
    }

    public function it_should_set_middle_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksMiddleName',
            [Faker::getInstance()->firstName()]
        );
    }

    public function it_should_set_last_name_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksLastName',
            [Faker::getInstance()->lastName()]
        );
    }

    public function it_should_set_full_name_correctly()
    {
        $faker = Faker::getInstance();
        $this->shouldNotThrow()->during(
            'setBackgroundChecksFullName',
            ["{$faker->firstName()} {$faker->lastName()}"]
        );
    }

    public function it_should_set_date_of_birth_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksDateOfBirth',
            [Faker::getInstance()->date('Y-m-d')]
        );

        $this->shouldNotThrow()->during(
            'setBackgroundChecksDateOfBirth',
            ['']
        );
    }

    public function it_should_set_async_update_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksAsyncUpdate',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setBackgroundChecksAsyncUpdate',
            [1]
        );
    }
}

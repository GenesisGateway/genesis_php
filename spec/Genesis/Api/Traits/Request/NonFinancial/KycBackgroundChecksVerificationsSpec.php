<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationAmlFilters;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\KycBackgroundChecksVerificationsStub;
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

    public function it_should_fail_when_set_wrong_aml_filters()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setBackgroundChecksFilters', [['wrong_value']]);
    }

    public function it_should_fail_when_add_wrong_aml_filters()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('addBackgroundChecksFilters', ['wrong_value']);
    }
    public function it_should_set_valid_aml_filters()
    {
        $faker = Faker::getInstance();
        $filter = [$faker->randomElement(VerificationAmlFilters::getAll())];
        $this->shouldNotThrow()
            ->during('setBackgroundChecksFilters', [$filter]);
    }

    public function it_should_add_valid_aml_filters()
    {
        $faker = Faker::getInstance();
        $filter = $faker->randomElement(VerificationAmlFilters::getAll());
        $this->shouldNotThrow()
            ->during('addBackgroundChecksFilters', [$filter]);
    }

    public function it_should_set_valid_match_score()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksMatchScore',
            [Faker::getInstance()->randomNumber(3)]
        );
    }

    public function it_should_fail_when_incorrect_match_score()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBackgroundChecksMatchScore',
            [-124]
        );

        $this->shouldThrow(InvalidArgument::class)->during(
            'setBackgroundChecksMatchScore',
            ['string']
        );
    }
}

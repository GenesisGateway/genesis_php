<?php

namespace spec\Genesis\Api\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2\RecurringStub;
use spec\SharedExamples\Faker;

/**
 * Class RecurringAttributesSpec
 * @package spec\Genesis\Api\Traits\Request\Financial\Threeds\V2
 */
class RecurringAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(RecurringStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('expiration_date');
        $this->getStructure()->shouldHaveKey('frequency');
    }

    public function it_should_set_correct_expiration_date()
    {
        $dateString = Faker::getInstance()->time(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setThreedsV2RecurringExpirationDate($dateString)->shouldHaveType(RecurringStub::class);
        $this->getThreedsV2RecurringExpirationDate()->shouldBeString();
        $this->getThreedsV2RecurringExpirationDate()->shouldBe($dateString);
    }

    public function it_should_fail_with_invalid_expiration_date()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2RecurringExpirationDate',
            ['invalid']
        );
    }

    public function it_should_set_correct_frequency()
    {
        $number = (string) rand(1, 9999);

        $this->setThreedsV2RecurringFrequency($number)->shouldHaveType(RecurringStub::class);
        $this->getThreedsV2RecurringFrequency()->shouldBeInt();
        $this->getThreedsV2RecurringFrequency()->shouldBe((int) $number);
    }

    public function it_should_fail_with_invalid_frequency()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2RecurringFrequency',
            [rand(10000, PHP_INT_MAX)]
        );

        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2RecurringFrequency',
            [rand(-100000, 0)]
        );
    }

    public function getMatchers(): array
    {
        return array(
            'beNotEmptyArray' => function ($subject) {
                return is_array($subject) && count($subject) > 0;
            }
        );
    }
}

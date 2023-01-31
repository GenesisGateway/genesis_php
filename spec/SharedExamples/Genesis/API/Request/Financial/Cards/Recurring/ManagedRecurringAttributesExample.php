<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial\Cards\Recurring;

use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\AmountTypes;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Frequencies;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Intervals;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Modes;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\PaymentTypes;
use Genesis\Exceptions\ErrorParameter;

trait ManagedRecurringAttributesExample
{
    public function it_should_pass_with_correct_data()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setManagedRecurringMode(Modes::AUTOMATIC);
        $this->setManagedRecurringPeriod(10);
        $this->setManagedRecurringInterval('days');
        $this->setManagedRecurringFirstDate($faker->date('d-m-Y'));
        $this->setManagedRecurringTimeOfDay(12);
        $this->setManagedRecurringAmount(5);
        $this->setManagedRecurringMaxCount(5);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_throw_with_missing_mode()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setManagedRecurringInterval('days');
        $this->setManagedRecurringPeriod(12);
        $this->setManagedRecurringFirstDate($faker->date('d-m-Y'));
        $this->setManagedRecurringTimeOfDay(12);
        $this->setManagedRecurringAmount(5);
        $this->setManagedRecurringMaxCount(5);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_managed_recurring_parameters_node()
    {
        $this->setRequestParameters();

        $this->setManagedRecurringMode(Modes::AUTOMATIC);

        $this->getDocument()->shouldContain('<managed_recurring>');
    }

    public function it_should_not_add_managed_recurring_when_missing()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<managed_recurring>');
    }

    public function it_should_add_common_and_indian_card_managed_recurring_parameters()
    {
        $this->setRequestParameters();

        $this->setCurrency('EUR');

        $this->setManagedRecurringMode(Modes::MANUAL);
        $this->setManagedRecurringPeriod(12);
        $this->setManagedRecurringInterval(Intervals::MONTHS);
        $this->setManagedRecurringFirstDate('2030-01-01');
        $this->setManagedRecurringTimeOfDay(12);
        $this->setManagedRecurringAmount(0.99);
        $this->setManagedRecurringMaxCount(2);

        // Indian Card specifics
        $this->setManagedRecurringPaymentType(PaymentTypes::INITIAL);
        $this->setManagedRecurringAmountType(AmountTypes::FIXED);
        $this->setManagedRecurringFrequency(Frequencies::EVERY_TWO_MONTHS);
        $this->setManagedRecurringRegistrationReferenceNumber('some_identifier');
        $this->setManagedRecurringMaxAmount(1.99);
        $this->setManagedRecurringValidated(false);

        $this->getDocument()->shouldContain(
            "\n\x20\x20<managed_recurring>" .
            "\n\x20\x20\x20\x20<mode>manual</mode>" .
            "\n\x20\x20\x20\x20<interval>months</interval>" .
            "\n\x20\x20\x20\x20<first_date>2030-01-01</first_date>" .
            "\n\x20\x20\x20\x20<time_of_day>12</time_of_day>" .
            "\n\x20\x20\x20\x20<period>12</period>" .
            "\n\x20\x20\x20\x20<amount>99</amount>" .
            "\n\x20\x20\x20\x20<max_count>2</max_count>" .
            "\n\x20\x20\x20\x20<payment_type>initial</payment_type>" .
            "\n\x20\x20\x20\x20<amount_type>fixed</amount_type>" .
            "\n\x20\x20\x20\x20<frequency>every_two_months</frequency>" .
            "\n\x20\x20\x20\x20<registration_reference_number>some_identifier</registration_reference_number>" .
            "\n\x20\x20\x20\x20<max_amount>199</max_amount>" .
            "\n\x20\x20\x20\x20<validated>false</validated>" .
            "\n\x20\x20</managed_recurring>"
        );
    }
}

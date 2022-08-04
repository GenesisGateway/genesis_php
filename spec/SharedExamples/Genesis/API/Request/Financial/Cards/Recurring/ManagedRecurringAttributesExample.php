<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial\Cards\Recurring;

trait ManagedRecurringAttributesExample
{
    public function it_should_pass_with_correct_data()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setManagedRecurringPeriod(10);
        $this->setManagedRecurringInterval('days');
        $this->setManagedRecurringFirstDate($faker->date('d-m-Y'));
        $this->setManagedRecurringTimeOfDay(12);
        $this->setManagedRecurringAmount(5);
        $this->setManagedRecurringMaxCount(5);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_throw_with_missing_period()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setManagedRecurringInterval('days');
        $this->setManagedRecurringFirstDate($faker->date('d-m-Y'));
        $this->setManagedRecurringTimeOfDay(12);
        $this->setManagedRecurringAmount(5);
        $this->setManagedRecurringMaxCount(5);

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_throw_with_incorrect_interval()
    {
        $this->shouldThrow()->during('setManagedRecurringInterval', [$this->getFaker()]);
    }

    public function it_should_not_add_managed_recurring_when_missing()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<managed_recurring>');
    }
}

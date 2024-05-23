<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring;

use Genesis\Api\Constants\Transaction\Parameters\ManagedRecurring\Modes;
use Genesis\Api\Constants\Transaction\Parameters\Recurring\Types;
use Genesis\Api\Request\Financial\Cards\Authorize3D;
use Genesis\Api\Request\Financial\Cards\Sale3D;
use Genesis\Api\Request\Wpf\Create as WpfCreate;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\Exception\Example\SkippingException;
use spec\SharedExamples\Faker;

trait RecurringTypeAttributesExample
{
    public function it_should_not_fail_with_valid_recurring_type()
    {
        $this->setRequestParameters();
        $this->setRecurringType(Types::INITIAL);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_invalid_recurring_type()
    {
        $this->setRequestParameters();
        $this->setRecurringType('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_recurring_type_when_set()
    {
        $this->setRequestParameters();
        $this->setRecurringType(Types::INITIAL);

        $this->getDocument()->shouldContain('<recurring_type>' . Types::INITIAL . '</recurring_type>');
    }

    public function it_should_not_contain_recurring_type_when_not_set()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<recurring_type>');
    }

    public function it_should_not_fail_with_managed_type_when_managed_recurring_available_for_every_transaction()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException(
                get_class($this->getWrappedObject()) . ' doesn\'t support Managed Recurring Attributes'
            );
        }

        $this->setRequestParameters();
        $this->setRecurringType(Types::MANAGED);
        $this->setManagedRecurringMode(Modes::MANUAL);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_managed_type_when_managed_recurring_missing_for_every_transaction()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException(
                get_class($this->getWrappedObject()) . ' doesn\'t support Managed Recurring Attributes'
            );
        }

        $this->setRequestParameters();
        $this->setRecurringType(Types::MANAGED);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_with_subsequent_type_when_set_reference_id_for_sale_transaction()
    {
        $this->handleSkipperSubsequentTransactionTypes();

        $this->setRequestParameters();
        $this->setRecurringType(Types::SUBSEQUENT);
        $this->setReferenceId(Faker::getInstance()->uuid);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_subsequent_type_when_not_set_reference_id_for_sale_transaction()
    {
        $this->handleSkipperSubsequentTransactionTypes();

        $this->setRequestParameters();
        $this->setRecurringType(Types::SUBSEQUENT);

        $this->shouldNotThrow(ErrorParameter::class)->during('getDocument');
    }

    /**
     * Skip Subsequent Recurring Type for unsupported Transaction request
     *
     * @return void
     * @throws SkippingException
     */
    private function handleSkipperSubsequentTransactionTypes()
    {
        if (
            $this->getWrappedObject() instanceof Authorize3D ||
            $this->getWrappedObject() instanceof Sale3D ||
            $this->getWrappedObject() instanceof WpfCreate
        ) {
            throw new SkippingException(
                get_class($this->getWrappedObject()) . ' doesn\'t support Recurring Type: subsequent'
            );
        }
    }
}

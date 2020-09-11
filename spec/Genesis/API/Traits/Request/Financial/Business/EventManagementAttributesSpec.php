<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class EventManagementAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_event_start_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessEventStartDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_event_start_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessEventStartDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_event_end_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessEventEndDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_event_end_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessEventEndDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_be_business_event_start_date()
    {
        $this->setBusinessEventStartDate('12-12-2021');
        $this->getBusinessEventStartDate()->shouldBeString();
    }

    public function it_should_be_business_event_end_date()
    {
        $this->setBusinessEventEndDate('12-12-2021');
        $this->getBusinessEventEndDate()->shouldBeString();
    }
}

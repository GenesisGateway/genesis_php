<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class CruiseLinesAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_cruise_start_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessCruiseStartDate',
            ['12-11-2020', '03-02-2020']
        );
    }

    public function it_should_fail_when_business_cruise_start_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessCruiseStartDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_cruise_end_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessCruiseEndDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_cruise_end_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessCruiseEndDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_be_business_cruise_start_date()
    {
        $this->setBusinessCruiseStartDate('12-12-2021');
        $this->getBusinessCruiseStartDate()->shouldBeString();
    }

    public function it_should_be_business_cruise_end_date()
    {
        $this->setBusinessCruiseEndDate('12-12-2021');
        $this->getBusinessCruiseEndDate()->shouldBeString();
    }
}

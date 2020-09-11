<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class HotelsAndRealEstateRentalsAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_check_in_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessCheckInDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_check_in_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessCheckInDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_check_out_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessCheckOutDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_check_out_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessCheckOutDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_be_business_check_in_date()
    {
        $this->setBusinessCheckInDate('12-12-2021');
        $this->getBusinessCheckInDate()->shouldBeString();
    }

    public function it_should_be_business_check_out_date()
    {
        $this->setBusinessCheckOutDate('12-12-2021');
        $this->getBusinessCheckOutDate()->shouldBeString();
    }
}

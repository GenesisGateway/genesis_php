<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Business;

use Genesis\Api\Constants\DateTimeFormat;
use spec\SharedExamples\Faker;

/**
 * Trait BusinessAttributesExample
 * @package spec\SharedExamples\Genesis\Api\Request\Financial\Business
 */
trait BusinessAttributesExample
{
    public function it_should_contain_business_attributes_key()
    {
        $this->setRequestParameters();
        $this->setBusinessAirlineCode('123456789');

        $this->getDocument()->shouldContain('business_attributes');
    }

    public function it_should_accept_valid_business_event_start_date()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('setBusinessEventStartDate', [
            Faker::getInstance()->date(
                Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats())
            )
        ]);
    }
}

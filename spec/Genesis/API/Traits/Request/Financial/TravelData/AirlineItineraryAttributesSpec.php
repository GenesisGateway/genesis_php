<?php

namespace spec\Genesis\API\Traits\Request\Financial\TravelData;

use Genesis\API\Request\Financial\TravelData\AirlineItineraryLegData;
use Genesis\API\Traits\Request\Financial\TravelData\AirlineItineraryAttributes;
use Genesis\API\Request\Financial\TravelData\AirlineItineraryTaxesData;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\TravelData\TravelDataAttributesStub;
use spec\SharedExamples\Faker;

class AirlineItineraryAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TravelDataAttributesStub::class);
    }

    public function it_should_set_restricted_ticket_indicator_correctly()
    {
        $allowed = ['', 0, 1];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setAidRestrictedTicketIndicator',
                [$value]
            );
        }
    }

    /**
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function it_should_fail_with_more_than_ten_legs_invalid()
    {

        for ($i = 0; $i < AirlineItineraryLegData::getMaxCount(); $i++) {
            $this->addAdditionalAidAttributes(
                new AirlineItineraryLegData(
                    '2019-03-03',
                    'AB',
                    'C',
                    'SOF',
                    'PRG',
                    0,
                    '2020-03-03',
                    'DDD'
                )
            );
        }

        $this->shouldThrow()->during(
            'addAdditionalAidAttributes',
            [
                new AirlineItineraryLegData(
                    '2019-03-03',
                    'AB',
                    'C',
                    'SOF',
                    'PRG',
                    0,
                    '2020-03-03',
                    'DDD'
                )
            ]
        );
    }

    /**
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function it_should_fail_with_more_than_ten_taxes_invalid()
    {
        for ($i = 0; $i < AirlineItineraryTaxesData::getMaxCount(); $i++) {
            $this->addAdditionalAidAttributes(
                new AirlineItineraryTaxesData(
                    1,
                    'Aabbccdd'
                )
            );
        }

        $this->shouldThrow()->during(
            'addAdditionalAidAttributes',
            [
                new AirlineItineraryTaxesData(
                    1,
                    'Aabbccdd'
                )
            ]
        );
    }

    public function it_should_not_fail_when_set_correct_date_aid_date_of_issue()
    {
        $this->shouldNotThrow()->during('setAidDateOfIssue',
            [Faker::getInstance()->date('Y-m-d')]
        );
        $this->shouldNotThrow()->during('setAidDateOfIssue',
            [Faker::getInstance()->date('d.m.Y')]
        );
    }

    public function it_should_fail_when_set_invalid_date_aid_date_of_issue()
    {
        $this->shouldThrow()->during('setAidDateOfIssue',
            [Faker::getInstance()->date('Ymd')]
        );
    }

    public function it_should_return_string_aid_date_of_issue()
    {
        $this->setAidDateOfIssue(Faker::getInstance()->date('Y-m-d'))
            ->getAidDateOfIssue()->shouldBeString();
    }
}

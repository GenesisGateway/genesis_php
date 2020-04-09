<?php

namespace spec\Genesis\API\Traits\Request\Financial\TravelData;

use Genesis\API\Request\Financial\TravelData\AirlineItineraryLegData;
use Genesis\API\Traits\Request\Financial\TravelData\AirlineItineraryAttributes;
use Genesis\API\Request\Financial\TravelData\AirlineItineraryTaxesData;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\TravelData\TravelDataAttributesStub;

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
}

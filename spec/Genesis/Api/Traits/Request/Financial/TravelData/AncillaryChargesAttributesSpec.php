<?php

namespace spec\Genesis\Api\Traits\Request\Financial\TravelData;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\TravelData\TravelDataAttributesStub;

class AncillaryChargesAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TravelDataAttributesStub::class);
    }

    public function it_should_set_types_correctly()
    {
        $allowed = [
            'BF', 'BG', 'CF', 'CG', 'CO', 'FF', 'GF', 'GT', 'IE', 'LG', 'MD', 'ML', 'OT', 'PA', 'PT', 'SA', 'SB',
            'SF', 'ST', 'TS', 'UN', 'UP', 'WI'
        ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setAcType',
                [$value]
            );
        }

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setAcSubType',
                [$value]
            );
        }
    }
}

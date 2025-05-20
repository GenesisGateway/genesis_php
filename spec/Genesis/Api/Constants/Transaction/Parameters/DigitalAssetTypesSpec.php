<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Api\Constants\Transaction\Parameters\DigitalAssetTypes;
use PhpSpec\ObjectBehavior;

class DigitalAssetTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DigitalAssetTypes::class);
    }

    public function it_should_be_array_get_all()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_get_all()
    {
        $this->getAll()->shouldNotBeEqualTo([]);
    }

}

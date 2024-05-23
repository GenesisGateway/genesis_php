<?php

namespace spec\Genesis\Api\Traits\Request\Financial\Threeds\V2;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2\AllAttributesStub;
use spec\SharedExamples\Genesis\Api\Request\Financial\Threeds\V2\ThreedsV2AllCommonAttributesExamples;

/**
 * Class AllAttributesSpec
 * @package spec\Genesis\Api\Traits\Request\Financial\Three\V2
 */
class AllAttributesSpec extends ObjectBehavior
{
    use ThreedsV2AllCommonAttributesExamples;

    public function let()
    {
        $this->beAnInstanceOf(AllAttributesStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function getMatchers(): array
    {
        return array(
            'beNotEmptyArray' => function ($subject) {
                return is_array($subject) && count($subject) > 0;
            }
        );
    }
}

<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\AllAttributesStub;
use spec\SharedExamples\Genesis\API\Request\Financial\Threeds\V2\ThreedsV2AllCommonAttributesExamples;

/**
 * Class AllAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Three\V2
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

    public function getMatchers()
    {
        return array(
            'beNotEmptyArray' => function ($subject) {
                return is_array($subject) && count($subject) > 0;
            }
        );
    }
}

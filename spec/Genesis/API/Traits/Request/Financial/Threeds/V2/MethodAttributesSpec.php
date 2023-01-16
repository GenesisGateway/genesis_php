<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\MethodStub;
use spec\SharedExamples\Faker;

/**
 * Class MethodAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Threeds\V2
 */
class MethodAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(MethodStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('callback_url');
    }

    public function it_should_set_correct_callback_url()
    {
        $url = Faker::getInstance()->url;

        $this->setThreedsV2MethodCallbackUrl($url)->shouldHaveType(MethodStub::class);
        $this->getThreedsV2MethodCallbackUrl()->shouldBe($url);
    }

    public function it_should_fail_with_invalid_callback_url()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2MethodCallbackUrl',
            ['invalid_url']
        );
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

<?php

namespace spec\Genesis\Api\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeWindowSizes;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\DeviceTypes;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2\ControlStub;
use spec\SharedExamples\Faker;

/**
 * Class ControlAttributesSpec
 * @package spec\Genesis\Api\Traits\Request\Financial\Threeds\V2
 */
class ControlAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ControlStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('device_type');
        $this->getStructure()->shouldHaveKey('challenge_window_size');
        $this->getStructure()->shouldHaveKey('challenge_indicator');
    }

    public function it_should_set_correct_device_type()
    {
        $type = Faker::getInstance()->randomElement(DeviceTypes::getAll());

        $this->setThreedsV2ControlDeviceType($type)->shouldHaveType(ControlStub::class);
        $this->getThreedsV2ControlDeviceType()->shouldBe($type);
    }

    public function it_should_set_correct_challenge_window_size()
    {
        $size = Faker::getInstance()->randomElement(ChallengeWindowSizes::getAll());

        $this->setThreedsV2ControlChallengeWindowSize($size)->shouldHaveType(ControlStub::class);
        $this->getThreedsV2ControlChallengeWindowSize()->shouldBe($size);
    }

    public function it_should_set_correct_challenge_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(ChallengeIndicators::getAll());

        $this->setThreedsV2ControlChallengeIndicator($indicator)->shouldHaveType(ControlStub::class);
        $this->getThreedsV2ControlChallengeIndicator()->shouldBe($indicator);
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

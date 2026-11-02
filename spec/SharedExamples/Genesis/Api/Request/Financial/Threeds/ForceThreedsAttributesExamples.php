<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Threeds;

use Genesis\Exceptions\InvalidArgument;

/**
 * Shared examples for requests that use ForceThreedsAttributes
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial\Threeds
 */
trait ForceThreedsAttributesExamples
{
    public function it_should_set_force_threeds_with_valid_values()
    {
        $values = [
            [true, true],
            [false, false],
            ['true', true],
            ['false', false],
            [1, true],
            [0, false],
            ['1', true],
            ['0', false],
            ['', false]
        ];

        foreach ($values as $value) {
            list($input, $expected) = $value;

            $this->shouldNotThrow()->during('setForceThreeds', [$input]);
            $this->getForceThreeds()->shouldBe($expected);
        }
    }

    public function it_should_clear_force_threeds_with_null()
    {
        $this->setForceThreeds(true);
        $this->setForceThreeds(null);

        $this->getForceThreeds()->shouldBeNull();
    }

    public function it_should_fail_when_force_threeds_is_invalid()
    {
        $values = ['abc', '2', []];

        foreach ($values as $value) {
            $this->shouldThrow(InvalidArgument::class)->during('setForceThreeds', [$value]);
        }
    }

    public function it_should_contain_force_threeds_when_true()
    {
        $this->setRequestParameters();
        $this->setForceThreeds(true);

        $this->getDocument()->shouldContain('<force_threeds>true</force_threeds>');
    }

    public function it_should_not_contain_force_threeds_when_false()
    {
        $this->setRequestParameters();
        $this->setForceThreeds(false);

        $this->getDocument()->shouldNotContain('<force_threeds>');
    }

    public function it_should_not_contain_force_threeds_when_not_set()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<force_threeds>');
    }
}

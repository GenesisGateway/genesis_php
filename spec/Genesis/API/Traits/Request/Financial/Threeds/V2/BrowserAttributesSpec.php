<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\BrowserStub;
use spec\SharedExamples\Faker;

/**
 * Class BrowserAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Threeds\V2
 */
class BrowserAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BrowserStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('accept_header');
        $this->getStructure()->shouldHaveKey('java_enabled');
        $this->getStructure()->shouldHaveKey('language');
        $this->getStructure()->shouldHaveKey('color_depth');
        $this->getStructure()->shouldHaveKey('screen_height');
        $this->getStructure()->shouldHaveKey('screen_width');
        $this->getStructure()->shouldHaveKey('time_zone_offset');
        $this->getStructure()->shouldHaveKey('user_agent');
    }

    public function it_should_set_correct_accept_header()
    {
        $string = Faker::getInstance()->regexify('[a-z+A-Z+0-9+]{2048}');

        $this->setThreedsV2BrowserAcceptHeader($string)->shouldHaveType(BrowserStub::class);
        $this->getThreedsV2BrowserAcceptHeader()->shouldBe($string);
    }

    public function it_should_fail_with_invalid_accept_header()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2BrowserAcceptHeader',
            [Faker::getInstance()->regexify('[a-z+A-Z+0-9+]{2049,3000}')]
        );
    }

    public function it_should_set_correct_language()
    {
        $string = Faker::getInstance()->regexify('[a-z+A-Z+0-9+]{8}');

        $this->setThreedsV2BrowserLanguage($string)->shouldHaveType(BrowserStub::class);
        $this->getThreedsV2BrowserLanguage()->shouldBe($string);
    }

    public function it_should_fail_with_invalid_language()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2BrowserLanguage',
            [Faker::getInstance()->regexify('[a-z+A-Z+0-9+]{9,20}')]
        );
    }

    public function it_should_set_correct_java_enabled()
    {
        $this->setThreedsV2BrowserJavaEnabled('on')->shouldHaveType(BrowserStub::class);
        $this->getThreedsV2BrowserJavaEnabled()->shouldBeBool();
        $this->getThreedsV2BrowserJavaEnabled()->shouldBe(true);
    }

    public function it_should_set_correct_dolor_depth()
    {
        $number = (string) rand(-100000, PHP_INT_MAX);

        $this->setThreedsV2BrowserColorDepth($number)->shouldHaveType(BrowserStub::class);
        $this->getThreedsV2BrowserColorDepth()->shouldBeInt();
        $this->getThreedsV2BrowserColorDepth()->shouldBe((int) $number);
    }

    public function it_should_set_correct_screen_height()
    {
        $this->setThreedsV2BrowserScreenHeight('200')->shouldhaveType(BrowserStub::class);
        $this->getThreedsV2BrowserScreenHeight()->shouldBeInt();
        $this->getThreedsV2BrowserScreenHeight()->shouldBe(200);
    }

    public function it_should_set_correct_screen_width()
    {
        $this->setThreedsV2BrowserScreenWidth('200')->shouldHaveType(BrowserStub::class);
        $this->getThreedsV2BrowserScreenWidth()->shouldBeInt();
        $this->getThreedsV2BrowserScreenWidth()->shouldBe(200);
    }

    public function it_should_set_correct_time_zone_offset()
    {
        $string = Faker::getInstance()->regexify('[a-z+A-Z+0-9+]{5}');

        $this->setThreedsV2BrowserTimeZoneOffset($string)->shouldHaveType(BrowserStub::class);
        $this->getThreedsV2BrowserTimeZoneOffset()->shouldBe($string);
    }

    public function it_should_fail_with_invalid_time_zone_offset()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2BrowserTimeZoneOffset',
            [Faker::getInstance()->regexify('[a-z+A-Z+0-9+]{6,20}')]
        );
    }

    public function it_should_set_correct_user_agent()
    {
        $string = Faker::getInstance()->userAgent;

        $this->setThreedsV2BrowserUserAgent($string)->shouldHaveType(BrowserStub::class);
        $this->getThreedsV2BrowserUserAgent()->shouldBe($string);
    }

    public function it_should_fail_with_invalid_user_agent()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2BrowserUserAgent',
            [Faker::getInstance()->regexify('[a-z+A-Z+0-9+]{2049,3000}')]
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

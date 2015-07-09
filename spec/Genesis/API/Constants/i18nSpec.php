<?php

namespace spec\Genesis\API\Constants;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class i18nSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\i18n');
    }

    function it_should_validate_supported_languages()
    {
        $this::isValidLanguageCode('en')->shouldBe(true);

        $this::isValidLanguageCode('zh')->shouldBe(true);
    }

    function it_should_handle_unsupported_languages()
    {
        $this::isValidLanguageCode('us')->shouldBe(false);

        $this::isValidLanguageCode('cn')->shouldBe(false);
    }

    function it_should_handle_invalid_input()
    {
        $this::isValidLanguageCode('en_US')->shouldBe(false);

        $this::isValidLanguageCode(null)->shouldBe(false);

        $this::isValidLanguageCode(0)->shouldBe(false);

        $this::isValidLanguageCode("\x00")->shouldBe(false);

        $this::isValidLanguageCode(' ')->shouldBe(false);
    }
}

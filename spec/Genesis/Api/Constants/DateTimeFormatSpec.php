<?php

namespace spec\Genesis\Api\Constants;

use PhpSpec\ObjectBehavior;

class DateTimeFormatSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Api\Constants\DateTimeFormat');
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_be_array_with_dates()
    {
        $this->getDateFormats()->shouldBeArray();
    }
}

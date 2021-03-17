<?php

namespace spec\Genesis\API\Constants;

use PhpSpec\ObjectBehavior;

class DateTimeFormatSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\DateTimeFormat');
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

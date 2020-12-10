<?php

namespace spec\Genesis\Network;

use Genesis\Builder;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Network\Stubs\BaseStub;

class BaseSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BaseStub::class);
    }

    public function it_should_have_correct_content_type_xml()
    {
        $this->getContentType(Builder::XML)->shouldBe('text/xml');
    }

    public function it_should_have_correct_content_type_json()
    {
        $this->getContentType(Builder::JSON)->shouldBe('application/json');
    }

    public function it_should_have_correct_content_type_form()
    {
        $this->getContentType(Builder::FORM)->shouldBe('application/x-www-form-urlencoded');
    }

    public function it_should_throw_with_invalid_request_data_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during('getContentType', ['format']);
    }
}

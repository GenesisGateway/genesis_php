<?php

namespace spec\Genesis\API\Traits\Request\CustomerAddress;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\CustomerAddress\CustomerInfoAttributesStub;
use spec\SharedExamples\Faker;

class CustomerInfoAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CustomerInfoAttributesStub::class);
    }

    public function it_should_allow_regular_email()
    {
        $this->shouldNotThrow()->during('setCustomerEmail', [Faker::getInstance()->email]);
    }

    public function it_should_allow_accented_characters()
    {
        $this->shouldNotThrow()->during('setCustomerEmail', ['àèìòùÀÈÌÒÙér@subdomain.domain.com']);
    }

    public function it_should_allow_apostrophe_characters()
    {
        $this->shouldNotThrow()->during('setCustomerEmail', ['áéíóúýÁÉÍÓÚÝ@subdomain.domain.com']);
    }

    public function it_should_allow_caret_characters()
    {
        $this->shouldNotThrow()->during('setCustomerEmail', ['âêîôûÂÊÎÔÛ@subdomain.domain.com']);
    }

    public function it_should_allow_tilde_characters()
    {
        $this->shouldNotThrow()->during('setCustomerEmail', ['ãñõÃÑÕ@subdomain.domain.com']);
    }
}

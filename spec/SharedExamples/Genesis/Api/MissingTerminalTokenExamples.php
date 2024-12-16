<?php

namespace spec\SharedExamples\Genesis\Api;

use Genesis\Config;
use Genesis\Exceptions\InvalidArgument;
use spec\SharedExamples\Faker;

trait MissingTerminalTokenExamples
{
    public function it_should_throw_when_empty_terminal_token()
    {
        Config::setToken(null);
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_should_not_throw_when_terminal_token()
    {
        Config::setToken(Faker::getInstance()->uuid);
        $this->setRequestParameters();

        $this->shouldNotThrow()->during('getDocument');
    }
}

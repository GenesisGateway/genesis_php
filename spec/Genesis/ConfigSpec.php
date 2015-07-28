<?php

namespace spec\Genesis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Config');
    }

    function it_should_have_default_environment_sandbox()
    {
        $this::getEnvironment()->shouldBe('sandbox');
    }

    function it_should_set_environment()
    {
        $default = \Genesis\Config::$vault['environment'];

        \Genesis\Config::$vault['environment'] = 'production';

        $this::getEnvironment()->shouldBe('production');

        \Genesis\Config::$vault['environment'] = $default;
    }

    function it_should_have_default_endpoint()
    {
        $this::getEndpoint()->shouldBe('e-comprocessing.net');
    }

    function it_should_set_endpoint()
    {
        $default = \Genesis\Config::$vault['endpoint'];

        \Genesis\Config::$vault['endpoint'] = 'emp';

        $this::getEndpoint()->shouldBe('emerchantpay.net');

        \Genesis\Config::$vault['endpoint'] = 'emerchantpay';

        $this::getEndpoint()->shouldBe('emerchantpay.net');

        \Genesis\Config::$vault['endpoint'] = 'ecp';

        $this::getEndpoint()->shouldBe('e-comprocessing.net');

        \Genesis\Config::$vault['endpoint'] = 'e-comprocessing';

        $this::getEndpoint()->shouldBe('e-comprocessing.net');

        \Genesis\Config::$vault['endpoint'] = $default;
    }

    function it_should_have_default_interface()
    {
        $this::getInterface('builder')->shouldBe('xml');

        $this::getInterface('network')->shouldBe('curl');
    }

    function it_should_set_interface()
    {
        $this::setInterface('builder', 'json');

        $this::getInterface('builder')->shouldBe('json');

        $this::setInterface('builder', 'xml');

        $this::setInterface('network', 'stream');

        $this::getInterface('network')->shouldBe('stream');

        $this::setInterface('network', 'curl');
    }

    function it_should_have_valid_ca()
    {
        $this::getCertificateBundle()->shouldExist();

        $this::getCertificateBundle()->shouldBeReadable();

        $this::getCertificateBundle()->shouldNotBeEmpty();
    }

    function getMatchers()
    {
        return array(
            'beEmpty'       => function ($subject) {
                return filesize($subject) < 1;
            },
            'beReadable'    => function ($subject) {
                return is_readable($subject);
            },
            'exist'         => function ($subject) {
                return file_exists($subject);
            }
        );
    }
}

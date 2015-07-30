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
        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::STAGING
        );
    }

    function it_should_set_environment()
    {
        $this::setEnvironment(
            \Genesis\API\Constants\Environments::STAGING
        );

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::STAGING
        );

        $this::setEnvironment(
            \Genesis\API\Constants\Environments::PRODUCTION
        );

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::PRODUCTION
        );
    }

    function it_should_set_environment_via_aliases()
    {
        $this::setEnvironment('live');

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::PRODUCTION
        );

        $this::setEnvironment('prod');

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::PRODUCTION
        );

        $this::setEnvironment('production');

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::PRODUCTION
        );

        $this::setEnvironment('test');

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::STAGING
        );

        $this::setEnvironment('testing');

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::STAGING
        );

        $this::setEnvironment('staging');

        $this::getEnvironment()->shouldBe(
            \Genesis\API\Constants\Environments::STAGING
        );
    }

    function it_should_not_set_environment_on_invalid_argument()
    {
        $default = $this::getEnvironment();

        $this::shouldThrow()->during('setEnvironment', array('example.com'));

        $this::getEnvironment()->shouldBe($default);

        $this::shouldThrow()->during('setEnvironment', array(null));

        $this::getEnvironment()->shouldBe($default);

        $this::shouldThrow()->during('setEnvironment', array(' '));

        $this::getEnvironment()->shouldBe($default);

        $this::shouldThrow()->during('setEnvironment', array("\x00"));

        $this::getEnvironment()->shouldBe($default);

        $this::shouldThrow()->during('setEnvironment', array(mt_rand(0, 100)));

        $this::getEnvironment()->shouldBe($default);
    }

    function it_should_set_endpoint()
    {
        $this::setEndpoint(\Genesis\API\Constants\Endpoints::ECOMPROCESSING);

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint(\Genesis\API\Constants\Endpoints::EMERCHANTPAY);

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );
    }

    function it_should_set_endpoint_via_aliases()
    {
        $this::setEndpoint('ecp');

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint('e-comprocessing');

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint('www.e-comprocessing.com');

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint('emp');

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        $this::setEndpoint('emerchantpay');

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        $this::setEndpoint('www.emerchantpay.com');

        $this::getEndpoint()->shouldBe(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );
    }

    function it_should_not_set_endpoint_on_invalid_argument()
    {
        $default = $this::getEndpoint();

        $this::shouldThrow()->during('setEndpoint', array('example.com'));

        $this::getEndpoint()->shouldBe($default);

        $this::shouldThrow()->during('setEndpoint', array(null));

        $this::getEndpoint()->shouldBe($default);

        $this::shouldThrow()->during('setEndpoint', array(' '));

        $this::getEndpoint()->shouldBe($default);

        $this::shouldThrow()->during('setEndpoint', array("\x00"));

        $this::getEndpoint()->shouldBe($default);

        $this::shouldThrow()->during('setEndpoint', array(mt_rand(0, 100)));

        $this::getEndpoint()->shouldBe($default);
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

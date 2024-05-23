<?php

namespace spec\Genesis;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Constants\Environments;
use Genesis\Config;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;

class ConfigSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Config');
    }

    public function it_should_have_default_environment_sandbox()
    {
        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::STAGING
        );
    }

    public function it_should_set_environment()
    {
        $this::setEnvironment(
            \Genesis\Api\Constants\Environments::STAGING
        );

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::STAGING
        );

        $this::setEnvironment(
            \Genesis\Api\Constants\Environments::PRODUCTION
        );

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::PRODUCTION
        );
    }

    public function it_should_set_environment_via_aliases()
    {
        $this::setEnvironment('live');

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::PRODUCTION
        );

        $this::setEnvironment('prod');

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::PRODUCTION
        );

        $this::setEnvironment('production');

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::PRODUCTION
        );

        $this::setEnvironment('test');

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::STAGING
        );

        $this::setEnvironment('testing');

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::STAGING
        );

        $this::setEnvironment('staging');

        $this::getEnvironment()->shouldBe(
            \Genesis\Api\Constants\Environments::STAGING
        );
    }

    public function it_should_not_set_environment_on_invalid_argument()
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

    public function it_should_set_endpoint()
    {
        $this::setEndpoint(\Genesis\Api\Constants\Endpoints::ECOMPROCESSING);

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );
    }

    public function it_should_set_endpoint_via_aliases()
    {
        $this::setEndpoint('ecp');

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint('e-comprocessing');

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint('www.e-comprocessing.com');

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING
        );

        $this::setEndpoint('emp');

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        $this::setEndpoint('emerchantpay');

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        $this::setEndpoint('www.emerchantpay.com');

        $this::getEndpoint()->shouldBe(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );
    }

    public function it_should_not_set_endpoint_on_invalid_argument()
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

    public function it_should_have_default_interface()
    {
        $this::getInterface('builder')->shouldBe('xml');

        $this::getInterface('network')->shouldBe('curl');
    }

    public function it_should_set_interface()
    {
        $this::setInterface('builder', 'json');

        $this::getInterface('builder')->shouldBe('json');

        $this::setInterface('builder', 'xml');

        $this::setInterface('network', 'stream');

        $this::getInterface('network')->shouldBe('stream');

        $this::setInterface('network', 'curl');
    }

    public function it_should_have_default_force_smart_routing()
    {
        $this->shouldHaveDefaultSmartRouting();
    }

    public function it_should_set_force_smart_routing()
    {
        $this::setForceSmartRouting(false)->shouldBe(false);
    }

    public function it_should_get_force_smart_routing()
    {
        $this->getWrappedObject()::setForceSmartRouting(true);

        $this->shouldHaveEnabledSmartRouting();
    }

    public function it_has_staging_smart_router_subdomain()
    {
        $this::setEnvironment('staging');

        $this::getSubDomain('api_service')->shouldBe('staging.api.');
    }

    public function it_has_production_smart_router_subdomain()
    {
        $this::setEnvironment('prod');

        $this::getSubDomain('api_service')->shouldBe('prod.api.');
    }

    public function it_should_fail_when_invalid_settings_file()
    {
        $this->shouldThrow(InvalidArgument::class)->during('loadSettings', ['invalid_path']);
    }

    public function it_should_fail_when_invalid_setting_with_ini_file()
    {
        $settings_sample = dirname(dirname(__DIR__)) . '/settings_sample.ini';

        $this->shouldThrow(InvalidArgument::class)
            ->during('loadSettings', [$settings_sample]);
    }

    public function it_should_load_settings_with_ini_file()
    {
        $settings_fixture = dirname(__DIR__) . '/Fixtures/settings.ini';

        $this::loadSettings($settings_fixture);

        $this::getEndpoint()->shouldBe(Endpoints::EMERCHANTPAY);
        $this::getEnvironment()->shouldBe(Environments::STAGING);
        $this->shouldHaveDefaultSmartRouting();
        $this->shouldHaveDefaultUsername();
        $this->shouldHaveDefaultPassword();
        $this->shouldHaveDefaultToken();
        $this::getInterface('network')->shouldBe('curl');
        $this::getInterface('builder')->shouldBe('xml');
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty'                 => function ($subject) {
                return filesize($subject) < 1;
            },
            'beReadable'              => function ($subject) {
                return is_readable($subject);
            },
            'exist'                   => function ($subject) {
                return file_exists($subject);
            },
            'haveDefaultSmartRouting' => function () {
                return array_key_exists('force_smart_routing', Config::$vault) &&
                    Config::$vault['force_smart_routing'] === false;
            },
            'haveEnabledSmartRouting' => function() {
                return Config::getForceSmartRouting() === true;
            },
            'haveDefaultUsername'     => function() {
                return Config::getUsername() === 'ENTER_YOUR_USERNAME';
            },
            'haveDefaultPassword'     => function() {
                return Config::getPassword() === 'ENTER_YOUR_PASSWORD';
            },
            'haveDefaultToken'        => function() {
                return Config::getToken() === 'ENTER_YOUR_TOKEN';
            }
        );
    }
}

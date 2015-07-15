<?php

namespace spec\Genesis\Network;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\Config;

class cURLSpec extends ObjectBehavior
{
    protected $endpoint;
    protected $environment;

    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\cURL');
    }

    function it_can_connect_to_staging_gateway()
    {
        $this->saveEndpoint();
        $this->saveEnvironment();

        $endpoints = array(
            'emerchantpay',
            'ecomprocessing'
        );

        Config::setEnvironment('sandbox');

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->send_remote_connection(
                Config::getEnvironmentURL('https', 'gateway')
            );
        }

        $this->restoreEndpoint();
        $this->restoreEnvironment();
    }

    function it_can_connect_to_staging_wpf()
    {
        $this->saveEndpoint();
        $this->saveEnvironment();

        $endpoints = array(
            'emerchantpay',
            'ecomprocessing'
        );

        Config::setEnvironment('sandbox');

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->send_remote_connection(
                Config::getEnvironmentURL('https', 'wpf')
            );
        }

        $this->restoreEndpoint();
        $this->restoreEnvironment();
    }

    function it_can_connect_to_production_gateway()
    {
        $this->saveEndpoint();
        $this->saveEnvironment();

        $endpoints = array(
            'emerchantpay',
            'ecomprocessing'
        );

        Config::setEnvironment('live');

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->send_remote_connection(
                Config::getEnvironmentURL('https', 'gateway')
            );
        }

        $this->restoreEndpoint();
        $this->restoreEnvironment();
    }

    function it_can_connect_to_production_wpf()
    {
        $this->saveEndpoint();
        $this->saveEnvironment();

        $endpoints = array(
            'emerchantpay',
            'ecomprocessing'
        );

        Config::setEnvironment('live');

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->send_remote_connection(
                Config::getEnvironmentURL('https', 'wpf')
            );
        }

        $this->restoreEndpoint();
        $this->restoreEnvironment();
    }

    function send_remote_connection($remote_url)
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\UserAgent($faker));

        $options = array(
            'body'       => '',
            'type'       => 'GET',
            'url'        => $remote_url,
            'timeout'    => Config::getNetworkTimeout(),
            'ca_bundle'  => Config::getCertificateBundle(),
            'user_login' => Config::getUsername() . ':' . Config::getPassword(),
            'user_agent' => $faker->userAgent,
        );

        $this->prepareRequestBody($options);

        $this->shouldNotThrow()->during('execute');

        $this->getResponseBody()->shouldNotBeEmpty();

        // Check only the gate for time as its the only endpoint that provides server-time
        if (strpos($remote_url, 'gate.')) {
            $this->getResponseBody()->shouldNotBeOlder();
        }

        $this->getStatus()->shouldBe(200);
    }

    function saveEndpoint()
    {
        $this->endpoint = Config::getEndpoint();
    }

    function restoreEndpoint()
    {
        Config::setEndpoint(
            $this->endpoint
        );
    }

    function saveEnvironment()
    {
        $this->environment = Config::getEndpoint();
    }

    function restoreEnvironment()
    {
        Config::setEnvironment(
            $this->environment
        );
    }

    function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
            'beOlder' => function ($subject) {
                $diff = time() - strtotime($subject);

                return (($diff < 60) ? false : true);
            },
        );
    }
}

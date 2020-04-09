<?php

namespace spec\Genesis\Network;

use Genesis\API\Request;
use Genesis\Builder;
use PhpSpec\ObjectBehavior;
use Genesis\Config;

class StreamSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Stream');
    }

    public function it_can_connect_to_staging_gateway_environment()
    {
        $endpoints = array(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING,
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\API\Constants\Environments::STAGING
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('gateway'), Config::getEndpoint())
            );
        }
    }

    public function it_can_connect_to_staging_wpf_environment()
    {
        $endpoints = array(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING,
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\API\Constants\Environments::STAGING
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('wpf'), Config::getEndpoint())
            );
        }
    }

    public function it_can_connect_to_production_gateway_environment()
    {
        $endpoints = array(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING,
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\API\Constants\Environments::PRODUCTION
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('gateway'), Config::getEndpoint())
            );
        }
    }

    public function it_can_connect_to_production_wpf_environment()
    {
        $endpoints = array(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING,
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\API\Constants\Environments::PRODUCTION
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('wpf'), Config::getEndpoint())
            );
        }
    }

    protected function sendRemoteConnection($remote_url)
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\UserAgent($faker));

        $options = array(
            'body'       => '',
            'type'       => Request::METHOD_GET,
            'url'        => $remote_url,
            'timeout'    => Config::getNetworkTimeout(),
            'user_login' => Config::getUsername() . ':' . Config::getPassword(),
            'user_agent' => $faker->userAgent,
            'format'     => Builder::XML
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

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
            'beOlder' => function ($subject) {
                $diff = time() - strtotime($subject);

                return (($diff < 60) ? false : true);
            },
            'beFalse' => function ($subject) {
                return (!$subject) ? true : false;
            },
            'beTrue'  => function ($subject) {
                return ($subject) ? true : false;
            },
        );
    }
}

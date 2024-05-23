<?php

namespace spec\Genesis\Network;

use Genesis\Api\Request;
use Genesis\Builder;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Network\Stubs\CurlStub;
use spec\Genesis\Network\Stubs\Traits\GraphqlServiceUrl;
use spec\SharedExamples\Genesis\Network\GraphqlConnectionExample;
use spec\SharedExamples\Genesis\Network\HttpStatusExample;

// @codingStandardsIgnoreStart
class CurlSpec extends ObjectBehavior
// @codingStandardsIgnoreEnd
{
    use GraphqlConnectionExample;
    use GraphqlServiceUrl;
    use HttpStatusExample;

    public function let()
    {
        $this->beAnInstanceOf(CurlStub::class);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Curl');
    }

    public function it_can_connect_to_staging_gateway()
    {
        $this->getWrappedObject()->is_wpf  = false;
        $this->getWrappedObject()->is_prod = false;

        $endpoints = array(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\Api\Constants\Environments::STAGING
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('gateway'), Config::getEndpoint())
            );
        }
    }

    public function it_can_connect_to_staging_wpf()
    {
        $this->getWrappedObject()->is_wpf  = true;
        $this->getWrappedObject()->is_prod = false;

        $endpoints = array(
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\Api\Constants\Environments::STAGING
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('wpf'), Config::getEndpoint())
            );
        }
    }

    public function it_can_connect_to_production_gateway()
    {
        $this->getWrappedObject()->is_wpf  = false;
        $this->getWrappedObject()->is_prod = true;

        $endpoints = array(
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING,
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\Api\Constants\Environments::PRODUCTION
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('gateway'), Config::getEndpoint())
            );
        }
    }

    public function it_can_connect_to_production_wpf()
    {
        $this->getWrappedObject()->is_wpf  = true;
        $this->getWrappedObject()->is_prod = true;

        $endpoints = array(
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING,
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
        );

        Config::setEnvironment(
            \Genesis\Api\Constants\Environments::PRODUCTION
        );

        foreach ($endpoints as $endpoint) {
            Config::setEndpoint($endpoint);

            $this->sendRemoteConnection(
                sprintf('https://%s%s', Config::getSubDomain('wpf'), Config::getEndpoint())
            );
        }
    }

    public function it_should_return_correct_curl_http_post_method_option_by_type()
    {
        $this->getMethodOptionByType(Request::METHOD_POST)->shouldBe(
            [
                CURLOPT_POST => true
            ]
        );
    }

    public function it_should_return_correct_curl_http_put_method_option_by_type()
    {
        $this->getMethodOptionByType(Request::METHOD_PUT)->shouldBe(
            [
                CURLOPT_CUSTOMREQUEST => 'PUT'
            ]
        );
    }

    protected function sendRemoteConnection($remote_url, $authorization = Request::AUTH_TYPE_BASIC, $token = null, $status = 200)
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\UserAgent($faker));

        switch ($authorization) {
            case Request::AUTH_TYPE_TOKEN:
                $additionalOptions = [
                    'authorization' => Request::AUTH_TYPE_TOKEN,
                    'token'         => $token,
                    'type'          => Request::METHOD_POST,
                    'format'        => Builder::JSON
                ];
                break;
            default:
                $additionalOptions = [
                    'authorization' => Request::AUTH_TYPE_BASIC,
                    'user_login'    => Config::getUsername() . ':' . Config::getPassword(),
                    'type'          => Request::METHOD_GET,
                    'format'        => Builder::XML
                ];
        }

        $options = array_merge(
            [
                'body'          => '',
                'url'           => $remote_url,
                'timeout'       => Config::getNetworkTimeout(),
                'user_agent'    => $faker->userAgent

            ],
            $additionalOptions
        );

        $this->prepareRequestBody($options);

        $this->shouldNotThrow()->during('execute');

        $this->getResponseBody()->shouldNotBeEmpty();

        // Check only the gate for time as its the only endpoint that provides server-time
        if (strpos($remote_url, 'gate.')) {
            $this->getResponseBody()->shouldNotBeOlder();
        }

        $this->getStatus()->shouldBe($status);
    }

    public function getMatchers(): array
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

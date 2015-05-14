<?php

namespace spec\Genesis\Network;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\Config;

class StreamSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Stream');
    }

    function it_can_send_remote_connections()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\UserAgent($faker));

        $remote_url = Config::getEnvironmentURL('https', 'gateway', 443);

        $options = array(
            'body'       => '',
            'type'       => 'GET',
            'url'        => $remote_url,
            'ca_bundle'  => Config::getCertificateBundle(),
            'user_login' => Config::getUsername() . ':' . Config::getPassword(),
            'user_agent' => $faker->userAgent,
        );

        $this->prepareRequestBody($options);

        $this->shouldNotThrow()->duringExecute();

        $this->getResponseBody()->shouldNotBeEmpty();

        $this->getResponseBody()->shouldNotBeOlder();
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
            'beFalse' => function ($subject) {
                return (!$subject) ? true : false;
            },
            'beTrue'  => function ($subject) {
                return ($subject) ? true : false;
            },
        );
    }
}

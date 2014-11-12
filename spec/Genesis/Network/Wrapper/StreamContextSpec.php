<?php

namespace spec\Genesis\Network\Wrapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\GenesisConfig;

class StreamContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Wrapper\StreamContext');
    }

    function it_can_send_remote_connections()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\UserAgent($faker));

        $remote_url = GenesisConfig::getEnvironmentURL('https','gateway', 443);

        $options = array(
            'body'          => '',
            'type'          => 'GET',
            'url'           => $remote_url,
            'cert_ca'       => GenesisConfig::getCertificateAuthority(),
            'user_login'    => GenesisConfig::getUsername() . ':' . GenesisConfig::getPassword(),
            'user_agent'    => $faker->userAgent,
        );

        $this->prepareRequestBody($options);

        $this->shouldNotThrow()->duringExecute();

        $this->getResponseBody()->shouldNotBeEmpty();

        $this->getResponseBody()->shouldNotBeOlder();
    }

    function getMatchers()
    {
        return array(
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
            'beOlder' => function($subject) {
                    $diff = time() - strtotime($subject);
                    return (($diff < 60) ? false : true);
                },
            'beFalse' => function($subject) {
                    return (!$subject) ? true : false;
                },
            'beTrue' => function($subject) {
                    return ($subject) ? true : false;
                },
        );
    }
}

<?php

namespace spec\Genesis\Network\Wrapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\GenesisConfig;

class cURLSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Wrapper\cURL');
    }

    function it_can_send_remote_connections()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\UserAgent($faker));

        $remote_url = GenesisConfig::getEnvironmentURL('https','gateway', 443);

        $options = array(
            'debug'         => 'false',
            'type'          => 'GET',
            'url'           => $remote_url,
            'body'          => '',
            'cert_ca'       => GenesisConfig::getCertificateAuthority(),
            'protocol'      => 'https',
            'timeout'       => 60,
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
        );
    }
}

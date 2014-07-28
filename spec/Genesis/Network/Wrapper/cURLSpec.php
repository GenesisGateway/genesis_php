<?php

namespace spec\Genesis\Network\Wrapper;

require_once 'spec/Genesis/SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\Configuration;

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

        $remote_url = Configuration::getEnvironmentURL('https','gateway', 443);

        $options = array(
            'debug'         => 'false',
            'type'          => 'GET',
            'url'           => $remote_url,
            'body'          => '',
            'cert_ca'       => Configuration::getCertificateAuthority(),
            'protocol'      => 'https',
            'timeout'       => 60,
            'user_login'    => Configuration::getUsername() . ':' . Configuration::getPassword(),
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

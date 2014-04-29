<?php

namespace spec\Genesis\Network\Wrapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\Configuration;

class StreamContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Wrapper\StreamContext');
    }

    function it_can_send_remote_connections()
    {
        $remote_url = Configuration::getEnvironmentURL('https','gateway', 443);

        $options = array(
            'type'  => 'GET',
            'url'   => $remote_url,
            'body'  => '',
            'cert_ca'    => Configuration::getCertificateAuthority(),
            'user_login' => '',
            'user_agent' => '',
        );

        $this->prepareRequestBody($options);

        $this->shouldNotThrow()->duringSubmitRequest();

        $this->getResponseBody()->shouldNotBeEmpty();

        $this->getResponseBody()->shouldNotBeOlder();
    }

    function getMatchers()
    {
        return [
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
            'beOlder' => function($subject) {
                    $diff = time() - strtotime($subject);
                    return ($diff < 3600 ? false : true);
                },
            'beFalse' => function($subject) {
                    return (!$subject) ? true : false;
                },
            'beTrue' => function($subject) {
                    return ($subject) ? true : false;
                },
        ];
    }
}

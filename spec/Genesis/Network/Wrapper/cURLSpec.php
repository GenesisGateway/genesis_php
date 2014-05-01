<?php

namespace spec\Genesis\Network\Wrapper;

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
        $remote_url = Configuration::getEnvironmentURL('https','gateway', 443);

        $options = array(
            CURLOPT_HEADER          => true,
            CURLOPT_URL             => $remote_url,
            CURLOPT_RETURNTRANSFER  => true,
        );

        $this->setOptions($options);

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
        ];
    }
}

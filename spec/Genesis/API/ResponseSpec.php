<?php

namespace spec\Genesis\API;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use \Genesis\API\Request as Request;
use \Genesis\Network as Network;

class ResponseSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith(new Network\Request(new Request\FraudRelated\Blacklist()), null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Response');
    }

    function it_should_be_successful_on_approved_status()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->buildSample('approved')));
        $this->isSuccessful()->shouldBeTrue();
    }

    function it_should_be_successful_on_pending_async_status()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->buildSample('pending_async')));
        $this->isSuccessful()->shouldBeTrue();
    }

    function it_should_be_unsuccessful_on_error()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->buildSample('error')));
        $this->isSuccessful()->shouldBeFalse();
    }

    function it_should_be_unsuccessful_on_unknown_status()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->buildSample('non-existing-status')));
        $this->isSuccessful()->shouldBeFalse();
    }

    function it_should_maintain_response_integrity()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->buildSample('approved', 999)));
        $this->getResponseRaw()->shouldBe($this->buildSample('approved', 999));
    }

    function it_should_fail_parsing_on_null_response()
    {
        $this->shouldThrow('\Genesis\Exceptions\InvalidArgument')->during('parseResponse', array(null));
    }

    function it_should_fail_parsing_on_empty_response()
    {
        $this->shouldThrow('\Genesis\Exceptions\InvalidArgument')->during('parseResponse', array(''));
    }

    function it_should_return_correct_error_message()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->buildSample('approved', 420)));
        $this->getErrorDescription()->shouldBe('Wrong Workflow specified.');
    }

    function buildSample($response = '', $code = 00) {
        return '<?xml version="1.0" encoding="UTF-8"?><response><status>' . $response . '</status><code>' . $code . '</code></response>';
    }

    function getMatchers()
    {
        return array(
            'beEmpty' => function($subject) {
                    return empty($subject);
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
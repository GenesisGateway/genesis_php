<?php

namespace spec\Genesis\API;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
    private $sampleXML = '<?xml version="1.0" encoding="UTF-8"?><response><status>approved</status><response_code>00</response_code></response>';

    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Response');
    }

    function it_should_parse_file()
    {
        $this->shouldNotThrow()->duringParseResponse($this->sampleXML);
        $this->getResponseObject()->shouldNotBeEmpty();
    }

    function it_should_verify_the_code()
    {
        $this->shouldNotThrow()->duringParseResponse($this->sampleXML);
        $this->getResponseObject()->shouldNotBeEmpty();
        $this->isSuccess()->shouldBeTrue();
    }

    function it_should_fail_parsing()
    {
        $this->shouldThrow()->duringParseResponse(null);
    }

    function it_should_fail_during_verification()
    {
        $invalidXML = str_replace('00', '100', $this->sampleXML);

        $this->shouldNotThrow()->duringParseResponse($invalidXML);
        $this->getResponseObject()->shouldNotBeEmpty();
        $this->isSuccess()->shouldBeFalse();
    }

    function getMatchers()
    {
        return [
            'beEmpty' => function($subject) {
                    return empty($subject);
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
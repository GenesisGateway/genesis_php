<?php

namespace spec\Genesis\API;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use \Genesis\API\Request as Request;
use \Genesis\Network as Network;

class ResponseSpec extends ObjectBehavior
{

    public $sampleXML   = '<?xml version="1.0" encoding="UTF-8"?><response><status>approved</status><response_code>00</response_code></response>';
    public $invalidXML  = '<?xml version="1.0" encoding="UTF-8"?><response><status>approved</status><response_code>100</response_code></response>';

    function let()
    {
        $this->beConstructedWith(new Network\Request(new Request\Blacklist()), null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Response');
    }

    function it_should_parse_file()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->sampleXML));
        $this->getResponseObject()->shouldNotBeEmpty();
    }

    function it_should_verify_the_code()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->sampleXML));
        $this->getResponseObject()->shouldNotBeEmpty();
        $this->isSuccessful()->shouldBeTrue();
    }

    function it_should_fail_parsing()
    {
        $this->shouldThrow('\Genesis\Exceptions\InvalidArgument')->during('parseResponse', array(null));
    }

    function it_should_fail_during_verification()
    {
        $this->shouldNotThrow()->during('parseResponse', array($this->invalidXML));
        $this->getResponseObject()->shouldNotBeEmpty();
        $this->isSuccessful()->shouldBeFalse();
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
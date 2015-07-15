<?php

namespace spec\Genesis\Builders;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JSONSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\JSON');
    }

    function it_can_generate_content()
    {
        $this->populateNodes(array('root' => array('node1' => 'value1', 'node2' => 'value2')));
        $this->getOutput()->shouldNotBeEmpty();
    }

    function it_can_generate_valid_xml()
    {
        $this->populateNodes(array('root' => array('node1' => 'value1', 'node2' => 'value2')));
        $this->getOutput()->shouldNotBeEmpty();
        $this->getOutput()->shouldBeValidJSON();
    }

    function getMatchers()
    {
        return array(
            'beEmpty'     => function ($subject) {
                return empty($subject);
            },
            'beValidJSON' => function ($subject) {
                json_decode($subject);

                return (json_last_error() == JSON_ERROR_NONE);
            },
        );
    }
}

<?php

namespace spec\Genesis\Builders;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\Builder');
    }

    function it_can_generate_content()
    {
        $this->parseStructure(array('root' => array('node1'=>'value1', 'node2'=>'value2')), null);
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_can_generate_valid_xml()
    {
        $this->parseStructure(array('root' => array('node1'=>'value1', 'node2'=>'value2')), null);
        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldBeValidXML();
    }

    function getMatchers()
    {
        return array(
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
            'beValidXML' => function($subject) {
                    return (simplexml_load_string($subject)) ? true : false;
                },
        );
    }
}

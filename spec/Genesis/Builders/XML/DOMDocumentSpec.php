<?php

namespace spec\Genesis\Builders\XML;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DOMDocumentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\XML\DOMDocument');
    }

    function it_can_generate_content()
    {
        $this->populateNodes(array('root' => array('node1'=>'value1', 'node2'=>'value2')), null);
        $this->getOutput()->shouldNotBeEmpty();
    }

    function it_can_generate_valid_xml()
    {
        $this->populateNodes(array('root' => array('node1'=>'value1', 'node2'=>'value2')), null);
        $this->getOutput()->shouldNotBeEmpty();
        $this->getOutput()->shouldBeValidXML();
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

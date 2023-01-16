<?php

namespace spec\Genesis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builder');
    }

    public function it_can_generate_content()
    {
        $this->parseStructure(
            array(
                'root' => array(
                    'node1' => 'value1',
                    'node2' => 'value2'
                )
            ),
            null
        );
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_can_generate_valid_xml()
    {
        $this->parseStructure(
            array(
                'root' => array(
                    'node1' => 'value1',
                    'node2' => 'value2'
                )
            ),
            null
        );
        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldBeValidXML();
    }

    public function it_can_escape_illegal_characters()
    {
        $this->parseStructure(
            array('root' => array('amp' => 'http://domain.tld/?arg1=normal&arg2=<&arg3=>'), null)
        );
        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldBeValidXML();
        $this->getDocument()->shouldMatch('/&lt;/');
        $this->getDocument()->shouldMatch('/&amp;/');
        $this->getDocument()->shouldMatch('/&gt;/');
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
            'beValidXML' => function ($subject) {
                return (simplexml_load_string($subject)) ? true : false;
            },
        );
    }
}

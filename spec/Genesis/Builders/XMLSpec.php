<?php

namespace spec\Genesis\Builders;

use Genesis\Builders\XML;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XMLSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\XML');
    }

    public function it_can_generate_content()
    {
        $this->populateNodes(array('root' => array('node1' => 'value1', 'node2' => 'value2')));
        $this->getOutput()->shouldNotBeEmpty();
    }

    public function it_can_generate_valid_xml()
    {
        $this->populateNodes(array('root' => array('node1' => 'value1', 'node2' => 'value2')));
        $this->getOutput()->shouldNotBeEmpty();
        $this->getOutput()->shouldBeValidXML();
    }

    public function it_can_generate_valid_xml_with_attributes()
    {
        $this->populateNodes(
            array(
                'root' => array(
                    '@attributes' => array(
                        'attr1' => 'vall1'
                    ),
                    'node1'       => array(
                        '@cdata' => 'test'
                    ),
                    'node2'       => 'value2'
                )
            )
        );

        $this->getOutput()->shouldNotBeEmpty();
        $this->getOutput()->shouldBeValidXML();
    }

    public function it_can_escape_illegal_characters()
    {
        $this->populateNodes(
            array('root' => array('amp' => 'http://domain.tld/?arg1=normal&arg2=<&arg3=>'), null)
        );
        $this->getOutput()->shouldNotBeEmpty();
        $this->getOutput()->shouldBeValidXML();
        $this->getOutput()->shouldMatch('/&lt;/');
        $this->getOutput()->shouldMatch('/&amp;/');
        $this->getOutput()->shouldMatch('/&gt;/');
    }

    public function it_should_flush_memory_after_xml_document_generations(\XMLWriter $xmlWriter)
    {
        $this->context = $xmlWriter;

        $this->populateNodes(array('root' => array('node' => 'value')));

        $xmlWriter->outputMemory(true)->shouldHaveBeenCalled();
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
            'beValidXML' => function ($subject) {
                $prevFlag = libxml_use_internal_errors(true);

                $doc = new \DOMDocument();
                $doc->loadXML($subject);

                $errors = libxml_get_errors();

                libxml_use_internal_errors($prevFlag);

                return empty($errors);
            },
        );
    }
}

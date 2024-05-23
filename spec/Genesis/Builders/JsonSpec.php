<?php

namespace spec\Genesis\Builders;

use PhpSpec\ObjectBehavior;

class JsonSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\Json');
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
        $this->getOutput()->shouldBeValidJSON();
    }

    public function getMatchers(): array
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

<?php

namespace spec\Genesis\Builders;

use PhpSpec\ObjectBehavior;

class FORMSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\FORM');
    }

    public function it_can_generate_content()
    {
        $this->populateNodes(array('root' => array('node1' => 'value1', 'node2' => 'value2')));
        $this->getOutput()->shouldBeString();
    }

    public function it_can_generate_valid_query_string()
    {
        $this->populateNodes(array('root' => array('node1' => 'value1', 'node2' => 'value2', 'node3' => 'space char')));
        $this->getOutput()->shouldBeString();
        $this->getOutput()->shouldBeValidQueryString();
    }

    public function getMatchers(): array
    {
        return array(
            'beValidQueryString' => function ($subject) {
                if (strpos($subject, 'value1&') === false) {
                    return false;
                }

                if (strpos($subject, 'space+char') === false) {
                    return false;
                }

                return true;
            },
        );
    }
}

<?php

namespace spec\Genesis\Utils;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Common');
    }

    function it_should_underscore()
    {
        $this->uppercaseToUnderscore('TERMINAL')->shouldBe('T_E_R_M_I_N_A_L');
        $this->uppercaseToUnderscore('setClient')->shouldBe('set_Client');
    }

    function it_can_create_array_object()
    {
        $this->createArrayObject(array('key_example' => 'value_example'))->shouldBeAnInstanceOf('\ArrayObject');

        $this->createArrayObject(array('key_example' => 'value_example'))->key_example->shouldBe('value_example');
    }

    function it_can_sanitize_null_array()
    {
        $array = array('test', 'data', null, 'version');

        $this->emptyValueRecursiveRemoval($array)->shouldHaveASizeOf(3);

        $array = array(null, null, null,null, null, 3, null);

        $this->emptyValueRecursiveRemoval($array)->shouldHaveASizeOf(1);

    }

    function getMatchers()
    {
        return array(
            'haveASizeOf' => function($subject, $value) {
                    return (sizeof($subject) == $value);
                },
        );
    }
}

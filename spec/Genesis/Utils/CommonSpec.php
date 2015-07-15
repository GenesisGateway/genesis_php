<?php

namespace spec\Genesis\Utils;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \Genesis\Utils\Common
 */
class CommonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Common');
    }

    function it_can_convert_pascal_to_snake()
    {
        $tests = array(
            'mode'             => 'mode',
            'Mode'             => 'mode',
            'MODE'             => 'mode',
            'MoDe'             => 'mo_de',
            'uniqueid'         => 'uniqueid',
            'uniqueId'         => 'unique_id',
            'UniqueId'         => 'unique_id',
            'UniqueID'         => 'unique_id',
            'returnSuccessUrl' => 'return_success_url',
            'returnSuccessURL' => 'return_success_url',
            'ReturnSuccessUrl' => 'return_success_url',
            'ReturnSuccessURL' => 'return_success_url',
            'BillingFirstName' => 'billing_first_name',
            'billingFirstName' => 'billing_first_name',
            'billingAddress1'  => 'billing_address1',
            'BillingADDRESS1'  => 'billing_address1',
            'PDFLoad'          => 'pdf_load',
            'startMIDDLELast'  => 'start_middle_last',
            'AString'          => 'a_string',
            'Some4Numbers234'  => 'some4_numbers234',
            'TEST123String'    => 'test123_string',
        );

        foreach ($tests as $test => $result) {
            $this::pascalToSnakeCase($test)->shouldBeLike($result);
        }
    }

    function it_can_resolve_dynamic_methods()
    {
        $tests = array(
            'setMode'                   => array('set', 'mode'),
            'addMode'                   => array('add', 'mode'),
            'selectMODE'                => array('select', 'mode'),
            'setMoDe'                   => array('set', 'mo_de'),
            'isUniqueid'                => array('is', 'uniqueid'),
            'addUniqueId'               => array('add', 'unique_id'),
            'setUniqueId'               => array('set', 'unique_id'),
            'testUniqueID'              => array('test', 'unique_id'),
            'deleteReturnSuccessUrl'    => array('delete', 'return_success_url'),
            'updateReturnSuccessURL'    => array('update', 'return_success_url'),
            'closeReturnSuccessUrl'     => array('close', 'return_success_url'),
            'removeReturnSuccessURL'    => array('remove', 'return_success_url'),
            'subBillingFirstName'       => array('sub', 'billing_first_name'),
            'addBillingFirstName'       => array('add', 'billing_first_name'),
            'delBillingAddress1'        => array('del', 'billing_address1'),
            'remBillingADDRESS1'        => array('rem', 'billing_address1'),
            'testPDFLoad'               => array('test', 'pdf_load'),
            'closeStartMIDDLELast'      => array('close', 'start_middle_last'),
            'isAString'                 => array('is', 'a_string'),
            'addSome4Numbers234'        => array('add', 'some4_numbers234'),
            'remTEST123String'          => array('rem', 'test123_string'),
        );

        foreach ($tests as $test => $result) {
            $this::resolveDynamicMethod($test)->shouldBe($result);
        }
    }

    function it_can_create_array_object()
    {
        $this::createArrayObject(array('key_example' => 'value_example'))->shouldBeAnInstanceOf(
            '\ArrayObject'
        );

        $this::createArrayObject(array('key_example' => 'value_example'))->key_example->shouldBe(
            'value_example'
        );
    }

    function it_can_sanitize_null_array()
    {
        $array = array('test', 'data', null, 'version');

        $this::emptyValueRecursiveRemoval($array)->shouldHaveASizeOf(3);

        $array = array(null, null, null, null, null, 3, null);

        $this::emptyValueRecursiveRemoval($array)->shouldHaveASizeOf(1);
    }

    function getMatchers()
    {
        return array(
            'haveASizeOf' => function ($subject, $value) {
                return (sizeof($subject) == $value);
            },
        );
    }
}

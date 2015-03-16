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

	function it_can_pass_system_requirements()
	{
		$this->shouldNotThrow()->during('checkRequirements');
	}

    function it_can_convert_pascal_to_snake()
    {
	    $tests = array(
		    'mode'              => 'mode',
		    'Mode'              => 'mode',
		    'MODE'              => 'mode',
		    'MoDe'              => 'mo_de',
		    'uniqueid'          => 'uniqueid',
		    'uniqueId'          => 'unique_id',
		    'UniqueId'          => 'unique_id',
		    'UniqueID'          => 'unique_id',
		    'returnSuccessUrl'  => 'return_success_url',
		    'returnSuccessURL'  => 'return_success_url',
		    'ReturnSuccessUrl'  => 'return_success_url',
		    'ReturnSuccessURL'  => 'return_success_url',
		    'BillingFirstName'  => 'billing_first_name',
		    'billingFirstName'  => 'billing_first_name',
		    'billingAddress1'   => 'billing_address1',
		    'BillingADDRESS1'   => 'billing_address1',
		    'PDFLoad'           => 'pdf_load',
		    'startMIDDLELast'   => 'start_middle_last',
		    'AString'           => 'a_string',
		    'Some4Numbers234'   => 'some4_numbers234',
		    'TEST123String'     => 'test123_string',
	    );

	    foreach ($tests as $test => $result) {
		    $this->pascalToSnakeCase($test)->shouldBeLike($result);
	    }
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

	function it_can_parse_xml_to_array_object()
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?><response><arg1>val1</arg1><arg2>val2</arg2></response>';

		$this->shouldNotThrow()->during('parseXMLtoArrayObject', array($xml));
		$this->parseXMLtoArrayObject($xml)->shouldBeAnInstanceOf('\ArrayObject');
		$this->parseXMLtoArrayObject($xml)->arg1->shouldBeLike('val1');
		$this->parseXMLtoArrayObject($xml)->arg2->shouldBeLike('val2');
	}

	function it_can_recover_from_invalid_xml()
	{
		$this->shouldNotThrow()->during('parseXMLtoArrayObject', array(''));
		$this->parseXMLtoArrayObject('')->shouldBe(false);
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

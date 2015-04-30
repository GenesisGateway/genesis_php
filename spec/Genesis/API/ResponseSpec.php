<?php

namespace spec\Genesis\API;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use \Genesis\API\Request as Request;
use \Genesis\Network as Network;

class ResponseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Response');
    }

    function it_should_be_successful_on_approved_status()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved')
                )
            )
        );

        $this->isSuccessful()->shouldBe(true);
    }

    function it_should_be_successful_on_new_status()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('new')
                )
            )
        );

        $this->isSuccessful()->shouldBe(true);
    }

    function it_should_be_successful_on_pending_async_status()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('pending_async')
                )
            )
        );

        $this->isSuccessful()->shouldBe(true);
    }

    function it_should_be_unsuccessful_on_error()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorAPI')->during(
            'parseResponse', array(
                $this->buildSample(
                    array('error')
                )
            )
        );

        $this->isSuccessful()->shouldBe(false);
    }

    function it_should_be_unsuccessful_on_unknown_status()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorAPI')->during(
            'parseResponse', array(
                $this->buildSample(
                    array('non-existing-status')
                )
            )
        );

        $this->isSuccessful()->shouldBe(false);
    }

    function it_should_parse_transaction_without_status()
    {
        $sample = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <code>00</code>
    <amount>00</amount>
</response>
XML;

        $this->shouldNotThrow()->during('parseResponse', array($sample));

        $this->isSuccessful()->shouldBe(null);
    }

    function it_should_maintain_response_integrity()
    {
        $xml_document = $this->buildSample(array('approved', 999));

        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $xml_document
            )
        );

        $this->getResponseRaw()->shouldBe($xml_document);
    }

    function it_should_fail_parsing_on_null_response()
    {
        $this->shouldThrow('\Genesis\Exceptions\InvalidResponse')->during(
            'parseResponse', array(null)
        );
    }

    function it_should_fail_parsing_on_empty_response()
    {
        $this->shouldThrow('\Genesis\Exceptions\InvalidResponse')->during(
            'parseResponse', array('')
        );
    }

    function it_should_return_correct_error_message()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 420)
                )
            )
        );

        $this->getErrorDescription()->shouldBe('Wrong Workflow specified.');
    }

    function it_should_successfully_parse_partial_approval()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 00, 90, 'USD', 'true')
                )
            )
        );

        $this->isPartiallyApproved()->shouldBe(true);
    }

    function it_should_fail_parsing_partial_approval()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 00, 90, 'USD', 'false')
                )
            )
        );

        $this->isPartiallyApproved()->shouldBe(false);
    }

    function it_should_get_formatted_amount()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 00, 314, 'USD')
                )
            )
        );

        $this->getResponseObject()->amount->shouldBe('3.14');
    }

    function it_should_get_formatted_timestamp()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 00, 314, 'USD', 'false')
                )
            )
        );

        $this->getResponseObject()->timestamp->shouldHaveType("DateTime");
    }

    function it_should_not_change_the_value_if_not_a_timestamp()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 00, 314, 'USD', 'false', 'ERROR')
                )
            )
        );

        $this->getResponseObject()->timestamp->shouldBe('ERROR');
    }

    function buildSample($settings = array())
    {
        list($status, $code, $amount, $currency, $partial_approval, $timestamp) = array_replace(
            array('', 00, 314, 'USD', false, '1970-01-01T00:00:00Z'), $settings
        );

        $payment_response = array(
            'payment_response' => array(
                'transaction_type'  => 'authorize',
                'code'              => $code,
                'status'            => $status,
                'unique_id'         => md5(time(false)),
                'transaction_id'    => md5(microtime(true)),
                'technical_message' => 'TESTMODE: No real money will be transferred!',
                'message'           => 'TESTMODE: No real money will be transferred!',
                'mode'              => 'test',
                'timestamp'         => $timestamp,
                'amount'            => $amount,
                'currency'          => $currency,
                'partial_approval'  => $partial_approval,
                'sent_to_acquirer'  => ''
            )
        );

        $xml = new \Genesis\Builder('xml');
        $xml->parseStructure($payment_response);

        return $xml->getDocument();
    }

    function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
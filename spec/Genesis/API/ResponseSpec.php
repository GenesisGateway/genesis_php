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
        $this->shouldNotThrow()->during(
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
        $this->shouldNotThrow()->during(
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
        $sample = '<?xml version="1.0" encoding="UTF-8"?><response><code>00</code><amount>00</amount></response>';

        $this->shouldNotThrow()->during('parseResponse', array($sample));

        $this->isSuccessful()->shouldBe(null);
    }

    function it_should_maintain_response_integrity()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 999)
                )
            )
        );

        $this->getResponseRaw()->shouldBe(
            $this->buildSample(
                array('approved', 999)
            )
        );
    }

    function it_should_fail_parsing_on_null_response()
    {
        $this->shouldThrow('\Genesis\Exceptions\InvalidArgument')->during(
            'parseResponse', array(null)
        );
    }

    function it_should_fail_parsing_on_empty_response()
    {
        $this->shouldThrow('\Genesis\Exceptions\InvalidArgument')->during(
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

        $this->getFormattedAmount()->shouldBe('3.14');
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

        $this->getFormattedTimestamp()->shouldHaveType("DateTime");
    }

    function it_should_throw_on_invalid_timestamp()
    {
        $this->shouldNotThrow()->during(
            'parseResponse', array(
                $this->buildSample(
                    array('approved', 00, 314, 'USD', 'false', 'INVALID_TIMESTAMP')
                )
            )
        );

        $this->shouldThrow()->during('getFormattedTimestamp');
    }

    function buildSample($settings = array())
    {
        list($response, $code, $amount, $currency, $partial_approval, $timestamp) = array_replace(
            array('', 00, 9000, 'USD', false, '2014-01-01T00:00:00Z'), $settings
        );

        return '<?xml version="1.0" encoding="UTF-8"?>
				<response>
					<status>' . $response . '</status>
					<code>' . $code . '</code>
					<amount>' . $amount . '</amount>
					<currency>' . $currency . '</currency>
					<partial_approval>' . $partial_approval . '</partial_approval>
					<timestamp>' . $timestamp . '</timestamp>
		        </response>';
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
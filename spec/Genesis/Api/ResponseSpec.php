<?php

namespace spec\Genesis\Api;

use Genesis\Exceptions\InvalidMethod;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\ResponseStub;
use spec\SharedExamples\Genesis\Api\ResponseErrorCodesExample;

class ResponseSpec extends ObjectBehavior
{
    use ResponseErrorCodesExample;

    public function let()
    {
        $this->beAnInstanceOf(ResponseStub::class);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Api\Response');
    }

    protected function prepareNetworkMock($network, $body, $headers = '', $status = 200)
    {
        $network->beADoubleOf('Genesis\Network');
        $network->getResponseBody()->willReturn($body);
        $network->getResponseHeaders()->willReturn($headers);
        $network->getStatus()->willReturn($status);
    }

    public function it_should_be_successful_on_approved_status($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSuccessful()->shouldBe(true);
    }

    public function it_should_be_successful_on_new_status($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('new')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSuccessful()->shouldBe(true);
    }

    public function it_should_be_successful_on_pending_async_status($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('pending_async')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSuccessful()->shouldBe(true);
    }

    public function it_should_not_throw_when_status_submitted($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('submitted')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_not_throw_when_status_pending_hold($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('pending_hold')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_not_throw_when_status_represented($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('represented')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_not_throw_when_status_second_chargebacked($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('second_chargebacked')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_be_unsuccessful_on_error($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('error')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSuccessful()->shouldBe(false);
    }

    public function it_should_be_unsuccessful_on_unknown_status($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('non-existing-status')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSuccessful()->shouldBe(null);
    }

    public function it_should_parse_transaction_without_status($network)
    {
        $sample = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <code>00</code>
    <amount>00</amount>
</response>
XML;

        $this->prepareNetworkMock($network, $sample);

        $this->shouldNotThrow()->during('parseResponse', array($network));

        $this->isSuccessful()->shouldBe(null);
    }

    public function it_should_maintain_response_integrity($network)
    {
        $xml_document = $this->buildSample(array('approved', 999));

        $this->prepareNetworkMock($network, $xml_document);

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->getResponseRaw()->shouldBe($xml_document);
    }

    public function it_should_not_fail_parsing_on_null_response($network)
    {
        $this->prepareNetworkMock($network, null);

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_not_fail_parsing_on_empty_response($network)
    {
        $this->prepareNetworkMock($network, '');

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_return_correct_error_message($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved', 420)
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->getErrorDescription()->shouldBe('Wrong Workflow specified.');
    }

    public function it_should_successfully_parse_partial_approval($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved', 00, 90, 'USD', 'true')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isPartiallyApproved()->shouldBe(true);
    }

    public function it_should_fail_parsing_partial_approval($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved', 00, 90, 'USD', 'false')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isPartiallyApproved()->shouldBe(false);
    }

    public function it_should_get_formatted_amount($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved', 00, 314, 'USD')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->getResponseObject()->amount->shouldBe('3.14');
    }

    public function it_should_get_formatted_timestamp($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved', 00, 314, 'USD', 'false')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->getResponseObject()->timestamp->shouldHaveType("DateTime");
    }

    public function it_should_not_change_the_value_if_not_a_timestamp($network)
    {
        // Prevent console SPAM due to error_log
        $log = ini_get('error_log');

        ini_set('error_log', '/dev/null');

        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved', 00, 314, 'USD', 'false', 'ERROR')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->getResponseObject()->timestamp->shouldBe('ERROR');

        ini_set('error_log', $log);
    }

    public function it_should_validate_json_header_case_insensitive()
    {
        $this->isResponseTypeJson('content-type: application/json')->shouldBe(true);
    }

    public function it_should_not_throw_when_status_is_array($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array(['status' => 'test'])
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_fail_with_invalid_magic_method_name($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('new')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->shouldThrow(InvalidMethod::class)->during('invalidMethodName');
    }

    public function it_should_fail_with_invalid_magic_method_status_name($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('new')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->shouldThrow(InvalidMethod::class)->during('isUnexistingInvalidStatusName');
    }

    public function it_should_have_status_approved($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('approved')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isApproved()->shouldBe(true);
    }

    public function it_should_have_status_declined($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('declined')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isDeclined()->shouldBe(true);
    }

    public function it_should_have_status_pending($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('pending')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isPending()->shouldBe(true);
    }

    public function it_should_have_status_pending_async($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('pending_async')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isPendingAsync()->shouldBe(true);
    }

    public function it_should_have_status_error($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('error')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isError()->shouldBe(true);
    }

    public function it_should_have_status_refunded($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('refunded')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isRefunded()->shouldBe(true);
    }

    public function it_should_have_status_voided($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('voided')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isVoided()->shouldBe(true);
    }

    public function it_should_have_status_disabled($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('disabled')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isDisabled()->shouldBe(true);
    }

    public function it_should_have_status_success($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('success')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSuccess()->shouldBe(true);
    }

    public function it_should_have_status_submitted($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('submitted')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSubmitted()->shouldBe(true);
    }

    public function it_should_have_status_pending_hold($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('pending_hold')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isPendingHold()->shouldBe(true);
    }

    public function it_should_have_status_second_chargebacked($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('second_chargebacked')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isSecondChargebacked()->shouldBe(true);
    }

    public function it_should_have_status_represented($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('represented')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isRepresented()->shouldBe(true);
    }

    public function it_should_have_status_in_progress($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('in_progress')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isInProgress()->shouldBe(true);
    }

    public function it_should_have_status_in_unsuccessful($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('unsuccessful')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isUnsuccessful()->shouldBe(true);
    }

    public function it_should_have_status_new($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('new')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isNew()->shouldBe(true);
    }

    public function it_should_have_status_user($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('user')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isUser()->shouldBe(true);
    }

    public function it_should_have_status_timeout($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('timeout')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isTimeout()->shouldBe(true);
    }

    public function it_should_have_status_chargebacked($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('chargebacked')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isChargebacked()->shouldBe(true);
    }

    public function it_should_have_status_chargeback_reversed($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('chargeback_reversed')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isChargebackReversed()->shouldBe(true);
    }

    public function it_should_have_status_representment_reversed($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('representment_reversed')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isRepresentmentReversed()->shouldBe(true);
    }

    public function it_should_have_status_pre_arbitrated($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('pre_arbitrated')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isPreArbitrated()->shouldBe(true);
    }

    public function it_should_have_status_active($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('active')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isActive()->shouldBe(true);
    }

    public function it_should_have_status_invalidated($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('invalidated')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isInvalidated()->shouldBe(true);
    }

    public function it_should_have_status_chargeback_reversal($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('chargeback_reversal')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isChargebackReversal()->shouldBe(true);
    }

    public function it_should_have_status_pending_review($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('pending_review')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isPendingReview()->shouldBe(true);
    }

    public function it_should_have_status_cancelled($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('cancelled')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isCancelled()->shouldBe(true);
    }

    public function it_should_have_status_accepted($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('accepted')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isAccepted()->shouldBe(true);
    }

    public function it_should_have_status_changed($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('changed')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isChanged()->shouldBe(true);
    }

    public function it_should_have_status_deleted($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('deleted')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isDeleted()->shouldBe(true);
    }

    public function it_should_have_status_received($network)
    {
        $this->prepareNetworkMock($network, $this->buildSample(
            array('received')
        ));

        $this->shouldNotThrow()->during(
            'parseResponse',
            array($network)
        );

        $this->isReceived()->shouldBe(true);
    }

    protected function buildSample($settings = array())
    {
        list($status, $code, $amount, $currency, $partial_approval, $timestamp) = array_replace(
            array(
                '',
                00,
                314,
                'USD',
                false,
                '1970-01-01T00:00:00Z'
            ),
            $settings
        );

        $payment_response = array(
            'payment_response' => array(
                'transaction_type'  => 'authorize',
                'code'              => $code,
                'status'            => $status,
                'unique_id'         => md5(time()),
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

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}

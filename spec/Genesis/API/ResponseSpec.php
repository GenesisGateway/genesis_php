<?php

namespace spec\Genesis\API;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use \Genesis\API\Request as Request;
use \Genesis\Network as Network;
use spec\Genesis\API\Stubs\Base\ResponseStub;

class ResponseSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ResponseStub::class);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Response');
    }

    protected function prepareNetworkMock($network, $body, $headers = '')
    {
        $network->beADoubleOf('Genesis\Network');
        $network->getResponseBody()->willReturn($body);
        $network->getResponseHeaders()->willReturn($headers);
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

        $this->shouldThrow('\Genesis\Exceptions\ErrorAPI')->during(
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

        $this->shouldThrow('\Genesis\Exceptions\InvalidArgument')->during(
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

    public function it_should_fail_parsing_on_null_response($network)
    {
        $this->prepareNetworkMock($network, null);

        $this->shouldThrow('\Genesis\Exceptions\InvalidResponse')->during(
            'parseResponse',
            array($network)
        );
    }

    public function it_should_fail_parsing_on_empty_response($network)
    {
        $this->prepareNetworkMock($network, '');

        $this->shouldThrow('\Genesis\Exceptions\InvalidResponse')->during(
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

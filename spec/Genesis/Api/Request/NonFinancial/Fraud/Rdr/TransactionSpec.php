<?php

namespace spec\Genesis\Api\Request\NonFinancial\Fraud\Rdr;

use Genesis\Api\Request\NonFinancial\Fraud\Rdr\Transaction;
use PhpSpec\ObjectBehavior;
use spec\Fixtures\Api\Stubs\Parser\ParserStub;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\Fraud\TransactionExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class TransactionSpec extends ObjectBehavior
{
    use RequestExamples;
    use TransactionExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::class);
    }

    public function it_should_parse_error_response_status($response)
    {
        $this->prepareErrorResponseMock($response);

        $this->response->getResponseObject()->status->shouldBe('error');
    }

    public function it_should_parse_error_response_code($response)
    {
        $this->prepareErrorResponseMock($response);

        $this->response->getResponseObject()->code->shouldBe('471');
    }

    public function it_should_parse_error_response_message($response)
    {
        $this->prepareErrorResponseMock($response);

        $this->response->getResponseObject()->message->shouldBe('Rapid Dispute Resolution not found!');
    }

    protected function prepareErrorResponseMock($response)
    {
        $parser = new ParserStub('NonFinancial\Fraud\Rdr');

        $response->beADoubleOf('Genesis\Api\Response');
        $response->getResponseObject()->willReturn(
            $parser->Transaction('xml', 'response')->getParsedDocument()
        );

        $this->response = $response;
    }
}

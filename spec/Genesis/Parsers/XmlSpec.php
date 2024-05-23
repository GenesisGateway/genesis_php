<?php

namespace spec\Genesis\Parsers;

use PhpSpec\ObjectBehavior;

class XmlSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Parsers\Xml');
    }

    public function it_should_parse_response()
    {
        $xml = file_get_contents('spec/Fixtures/Xml/GateAuthorizeRequest.xml');
        $this->skipRootNode();

        $this->parseDocument($xml);

        $this->getObject()->transaction_type->shouldBe('authorize');
        $this->getObject()->amount->shouldBe('5000');
        $this->getObject()->technical_message->shouldBe('Transaction successful!');
        $this->getObject()->sent_to_acquirer->shouldBe(true);
    }

    public function it_should_parse_urls()
    {
        $xml = file_get_contents('spec/Fixtures/Xml/GateApmRequest.xml');

        $this->skipRootNode();

        $this->parseDocument($xml);

        $this->getObject()->status->shouldBe('pending_async');

        $this->getObject()->redirect_url->shouldBe(
            'https://staging.gate.x.net/redirect/to_acquirer/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
        );
    }

    public function it_should_parse_multinodes()
    {
        $xml = file_get_contents('spec/Fixtures/Xml/WpfRequest.xml');

        $this->skipRootNode();

        $this->parseDocument($xml);

        $this->getObject()->billing_address->first_name->shouldBe('John');

        $this->getObject()->transaction_types->transaction_type->shouldHaveType('\ArrayObject');

        $this->getObject()->transaction_types->transaction_type->count()->shouldBe(5);
    }
}

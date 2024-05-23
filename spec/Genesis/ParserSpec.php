<?php

namespace spec\Genesis;

use PhpSpec\ObjectBehavior;

class ParserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Parser');
    }

    public function it_can_parse_content()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<payment_response>
  <transaction_type>authorize</transaction_type>
  <status>approved</status>
  <authorization_code>345678</authorization_code>
  <response_code>00</response_code>
  <unique_id>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</unique_id>
  <transaction_id>43671</transaction_id>
  <technical_message>Transaction successful!</technical_message>
  <message>Transaction successful!</message>
  <mode>live </mode>
  <timestamp>2007-08-30T17:46:11Z</timestamp>
  <descriptor>Descriptor One</descriptor>
  <amount>5000</amount>
  <currency>USD</currency>
  <sent_to_acquirer>true</sent_to_acquirer>
</payment_response>
XML;

        $this->shouldNotThrow()->during('parseDocument', array($xml));

        $this->getObject()->shouldHaveType('\stdClass');

        $this->getObject()->payment_response->status->shouldBe('approved');

        $this->getObject()->payment_response->unique_id->shouldBe('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

        $this->getObject()->payment_response->mode->shouldBe('live');

        $this->getObject()->payment_response->timestamp->shouldBe('2007-08-30T17:46:11Z');

        $this->getObject()->payment_response->sent_to_acquirer->shouldBe(true);
    }

    public function it_should_throw_on_invalid_document()
    {
        $xml = <<<XML
<?xml>
<root>
    <test>true</test>
</root>
XML;

        $this->shouldThrow()->during('parseDocument', array($xml));
    }

    public function it_should_not_throw_on_null()
    {
        $this->shouldNotThrow()->during('parseDocument', array(null));
    }
}

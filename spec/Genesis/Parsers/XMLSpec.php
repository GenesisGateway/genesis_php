<?php

namespace spec\Genesis\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XMLSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Parsers\XML');
    }

    function it_should_parse_response()
    {
        $xml
            = <<<XML
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
  <mode>live</mode>
  <timestamp>2007-08-30T17:46:11Z</timestamp>
  <descriptor>Descriptor One</descriptor>
  <amount>5000</amount>
  <currency>USD</currency>
  <sent_to_acquirer>true</sent_to_acquirer>
</payment_response>
XML;
        $this->skipRootNode();

        $this->parseDocument($xml);

        $this->getObject()->transaction_type->shouldBe('authorize');
        $this->getObject()->amount->shouldBe('5000');
        $this->getObject()->technical_message->shouldBe('Transaction successful!');
        $this->getObject()->sent_to_acquirer->shouldBe(true);
    }

    function it_should_parse_urls()
    {
        $xml
            = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<payment_response>
  <transaction_type>cashu</transaction_type>
  <status>pending_async</status>
  <unique_id>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</unique_id>
  <transaction_id>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</transaction_id>
  <technical_message>Transaction successful!</technical_message>
  <message>Transaction successful!</message>
  <redirect_url>
      https://staging.gate.x.net/redirect/to_acquirer/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
  </redirect_url>
  <mode>live</mode>
  <timestamp>2015-02-16T17:56:53Z</timestamp>
  <descriptor>descriptor one</descriptor>
  <amount>50000</amount>
  <currency>EUR</currency>
  <sent_to_acquirer>true</sent_to_acquirer>
</payment_response>
XML;

        $this->skipRootNode();

        $this->parseDocument($xml);

        $this->getObject()->status->shouldBe('pending_async');

        $this->getObject()->redirect_url->shouldBe(
            'https://staging.gate.x.net/redirect/to_acquirer/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
        );
    }

    function it_should_parse_multinodes()
    {
        $xml
            = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<wpf_payment>
  <transaction_id>wev238f328nc</transaction_id>
  <usage>Order ID 500, Shoes</usage>
  <description>You are about to buy 3 shoes at www.shoes.com!</description>
  <notification_url>https://example.com/notification</notification_url>
  <return_success_url>https://example.com/return_success</return_success_url>
  <return_failure_url>https://example.com/return_failure</return_failure_url>
  <return_cancel_url>https://example.com/return_cancel</return_cancel_url>
  <amount>5000</amount>
  <currency>USD</currency>
  <customer_email>john.doe@example.com</customer_email>
  <customer_phone>+11234567890</customer_phone>
  <card_holder> ‘‘‘‘‘‘ </card_holder>
  <billing_address>
    <first_name>John</first_name>
    <last_name>Doe</last_name>
    <address1>23, Doestreet</address1>
    <zip_code>11923</zip_code>
    <city>New York City</city>
    <state>NY</state>
    <country>US</country>
  </billing_address>
  <transaction_types>
    <transaction_type name="sale"/>
    <transaction_type name="sale3d"/>
    <transaction_type name="cashu"/>
    <transaction_type name="ezeewallet">
     <source_wallet_id>john@example.com</source_wallet_id>
    </transaction_type>
    <transaction_type name="paybyvoucher">
     <product_name>Some Product Name</product_name>
     <product_category>Some Product Category</product_category>
    </transaction_type>
  </transaction_types>
  <risk_params>
    <user_id>123456</user_id>
  </risk_params>
</wpf_payment>
XML;
        $this->skipRootNode();

        $this->parseDocument($xml);

        $this->getObject()->billing_address->first_name->shouldBe('John');

        $this->getObject()->transaction_types->transaction_type->shouldHaveType('\ArrayObject');

        $this->getObject()->transaction_types->transaction_type->count()->shouldBe(5);
    }
}

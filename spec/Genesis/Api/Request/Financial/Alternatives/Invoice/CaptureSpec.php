<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives\Invoice;

use Genesis\Api\Request\Financial\Alternatives\Invoice\Capture;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Item as InvoiceItem;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\Alternatives\Transaction\ItemsExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CaptureSpec extends ObjectBehavior
{
    use RequestExamples;
    use ItemsExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Capture::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'payment_type',
            'reference_id',
            'amount',
            'currency'
        ]);
    }

    public function it_should_fail_when_missing_required_items_param()
    {
        $this->setRequestParameters();
        $this->addItem(new InvoiceItem());
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('GBP');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_iban()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setIban', ['fake_iban']);
    }

    public function it_should_fail_when_wrong_payment_type()
    {
        $this->setRequestParameters();
        $this->setPaymentType('INVALID_PAYMENT_TYPE');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_set_merchant_marketplace_seller_info()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain(
            '      <merchant_data>
        <marketplace_seller_info>Electronic components</marketplace_seller_info>
      </merchant_data>'
        );
    }

    public function it_should_set_product_identifiers()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain(
            '      <product_identifiers>
        <brand>Brand</brand>
        <category_path>Category Path</category_path>
        <global_trade_item_number>GTIN</global_trade_item_number>
        <manufacturer_part_number>MPN</manufacturer_part_number>
      </product_identifiers>'
        );
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $item = $this->setItem();
        $this->addItem($item);
        $this->setAmount('4.95');

        $this->setPaymentType('secure_invoice');
        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setCurrency('EUR');
        $this->setAccountHolder('Ivan Ivanov');
        $this->setIban('DE09100100101234567891');
        $this->setBankTransferRemittanceSlip('123123123');
    }
}

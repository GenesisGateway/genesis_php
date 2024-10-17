<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives\Invoice;

use Genesis\Api\Constants\Financial\Alternative\Invoice\PaymentMethodCategories;
use Genesis\Api\Constants\Financial\Alternative\Invoice\PaymentTypes;
use Genesis\Api\Request\Financial\Alternatives\Invoice\Authorize;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Item as InvoiceItem;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\Alternatives\Transaction\ItemsExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class AuthorizeSpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;
    use ItemsExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Authorize::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'currency',
            'billing_country',
            'shipping_country',
            'return_success_url',
            'return_failure_url',
            'payment_method_category',
            'payment_type'
        ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('TR');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_wrong_shipping_country_parameter()
    {
        $this->setRequestParameters();
        $this->setShippingCountry('TR');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_wrong_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('GBP');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_required_items_param()
    {
        $this->setRequestParameters();
        $this->addItem(new InvoiceItem());
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_payment_method_category_param()
    {
        $this->setRequestParameters();
        $this->setPaymentMethodCategory('NOT_VALID_PAYMENT_METHOD_CATEGORY');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_payment_type_param()
    {
        $this->setRequestParameters();
        $this->setPaymentType('NOT_VALID_PAYMENT_TYPE');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_secure_invoice_and_missing_conditional_reference_number()
    {
        $this->setRequestParameters();
        $this->setPaymentType(PaymentTypes::SECURE_INVOICE);
        $this->setCustomerReferenceNumber(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_secure_invoice_and_missing_conditional_customer_birthdate()
    {
        $this->setRequestParameters();
        $this->setPaymentType(PaymentTypes::SECURE_INVOICE);
        $this->setCustomerBirthdate(null);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_when_klarna_and_missing_conditional_customer_reference_number()
    {
        $this->setRequestParameters();
        $this->setPaymentType(PaymentTypes::KLARNA);
        $this->setCustomerReferenceNumber(null);
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_klarna_and_missing_conditional_customer_birthdate()
    {
        $this->setRequestParameters();
        $this->setPaymentType(PaymentTypes::KLARNA);
        $this->setCustomerBirthdate(null);
        $this->shouldNotThrow()->during('getDocument');
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

    public function it_should_validate_amount()
    {
        $this->setRequestParameters();
        $this->setAmount('123.45');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_validate_amount_with_discount()
    {
        $this->setRequestParameters();
        $item = $this->setItem();
        $item->setTotalDiscountAmount('0.09');
        $this->addItem($item);
        $this->setAmount('9.81');
        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $item = $this->setItem();
        $this->addItem($item);

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setCustomerEmail($faker->email);
        $this->setAmount('4.95');
        $this->setRemoteIp($faker->ipv4);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setPaymentMethodCategory(
            $faker->randomElement(
                [
                    PaymentMethodCategories::PAY_LATER,
                    PaymentMethodCategories::PAY_OVER_TIME
                ]
            )
        );
        $this->setPaymentType(PaymentTypes::SECURE_INVOICE);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setCustomerGender($faker->randomElement(['male', 'female']));
        $this->setCustomerBirthdate($faker->date('Y-m-d'));
        $this->setCustomerReferenceNumber($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');

        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry('NL');

        $this->setShippingFirstName($faker->firstName);
        $this->setShippingLastName($faker->lastName);
        $this->setShippingAddress1($faker->streetAddress);
        $this->setShippingZipCode($faker->postcode);
        $this->setShippingCity($faker->city);
        $this->setShippingState($faker->state);
        $this->setShippingCountry('NL');
    }
}

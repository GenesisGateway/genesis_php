<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives\Klarna;

use Genesis\Api\Request\Financial\Alternatives\Klarna\Authorize;
use Genesis\Api\Request\Financial\Alternatives\Klarna\Item as KlarnaItem;
use Genesis\Api\Request\Financial\Alternatives\Klarna\Items as KlarnaItems;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class AuthorizeSpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples; 

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Genesis\Api\Request\Financial\Alternatives\Klarna\Authorize::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'remote_ip',
            'amount',
            'currency',
            'billing_country',
            'shipping_country',
            'return_success_url',
            'return_failure_url',
            'payment_method_category'
        ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('TR');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_shipping_country_parameter()
    {
        $this->setRequestParameters();
        $this->setShippingCountry('TR');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_items_param()
    {
        $this->setRequestParameters();
        $this->setItems(new KlarnaItems('EUR'));
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_payment_method_category_param()
    {
        $this->setRequestParameters();
        $this->setPaymentMethodCategory('NOT_VALID_PAYMENT_METHOD_CATEGORY');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $item  = new KlarnaItem(
            $faker->name,
            KlarnaItem::ITEM_TYPE_PHYSICAL,
            1,
            10,
            25
        );

        $items = new KlarnaItems('EUR');
        $items->addItem($item);

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setPaymentMethodCategory(Authorize::PAYMENT_METHOD_CATEGORY_PAY_LATER);
        $this->setAmount($items->getAmount());
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

        $this->setItems($items);
    }
}

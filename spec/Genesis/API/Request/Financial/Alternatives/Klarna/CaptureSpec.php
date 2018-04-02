<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\Klarna;

use PhpSpec\ObjectBehavior;
use \Genesis\API\Request\Financial\Alternatives\Klarna\Items as KlarnaItems;
use \Genesis\API\Request\Financial\Alternatives\Klarna\Item as KlarnaItem;

class CaptureSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(\Genesis\API\Request\Financial\Alternatives\Klarna\Capture::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_remote_ip_parameter()
    {
        $this->setRequestParameters();
        $this->setRemoteIp(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_items_param()
    {
        $this->setRequestParameters();
        $this->setItems(new KlarnaItems('EUR'));
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_reference_id_param()
    {
        $this->setRequestParameters();
        $this->setReferenceId(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
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

        $item  = new KlarnaItem(
            $faker->name,
            KlarnaItem::ITEM_TYPE_PHYSICAL,
            1,
            10,
            25
        );

        $items = new KlarnaItems('EUR');
        $items->addItem($item);

        $this->setItems($items);
    }

    public function getMatchers()
    {
        return [
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        ];
    }
}

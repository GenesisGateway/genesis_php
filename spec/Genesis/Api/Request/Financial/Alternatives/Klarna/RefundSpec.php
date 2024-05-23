<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives\Klarna;

use Genesis\Api\Request\Financial\Alternatives\Klarna\Item as KlarnaItem;
use Genesis\Api\Request\Financial\Alternatives\Klarna\Items as KlarnaItems;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class RefundSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Genesis\Api\Request\Financial\Alternatives\Klarna\Refund::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'remote_ip',
            'amount',
            'currency',
            'reference_id'
        ]);
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
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setAmount($items->getAmount());
        $this->setCurrency('EUR');

        $this->setItems($items);
    }
}

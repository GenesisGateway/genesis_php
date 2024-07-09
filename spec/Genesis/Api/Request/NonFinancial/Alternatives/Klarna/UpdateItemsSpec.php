<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna;

use Genesis\Api\Request\Financial\Alternatives\Klarna\Item as KlarnaItem;
use Genesis\Api\Request\Financial\Alternatives\Klarna\Items as KlarnaItems;
use Genesis\Api\Request\NonFinancial\Alternatives\Klarna\UpdateItems;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

/**
 * Class UpdateItemsSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna
 */
class UpdateItemsSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(UpdateItems::class);
    }

    public function it_should_use_builder_xml()
    {
        $this->getApiConfig('format')->shouldBe(Builder::XML);
    }

    public function it_should_contain_correct_parent_node()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('update_order_items_request');
    }

    public function it_should_fail_when_missing_required_items_param()
    {
        $this->setRequestParameters();
        $this->setItems(new KlarnaItems());
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount'
        ]);
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

        $items = new KlarnaItems();
        $items->addItem($item);

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setAmount($items->getAmount());
        $this->setCurrency('');

        $this->setItems($items);
    }
}

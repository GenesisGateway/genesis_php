<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna;

use Genesis\Api\Request\Financial\Alternatives\Transaction\Items as KlarnaItems;
use Genesis\Api\Request\NonFinancial\Alternatives\Klarna\UpdateItems;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Alternatives\Transaction\ItemsExample;

/**
 * Class UpdateItemsSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna
 */
class UpdateItemsSpec extends ObjectBehavior
{
    use RequestExamples;
    use ItemsExample;

    private $currency = 'EUR';

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

    /**
     * @throws InvalidArgument
     * @throws ErrorParameter
     */
    protected function setRequestParameters()
    {
        $faker = $this->getFaker();
        $this->setCurrency($this->currency);
        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $items = new KlarnaItems();
        $items->setCurrency($this->currency);

        $item = $this->setItem();
        $item->setTotalDiscountAmount('0.09');
        $this->addItem($item);
        $this->setAmount('9.81');
    }
}

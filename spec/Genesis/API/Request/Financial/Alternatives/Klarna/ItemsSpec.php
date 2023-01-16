<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\Klarna;

use PhpSpec\ObjectBehavior;
use \Genesis\API\Request\Financial\Alternatives\Klarna\Item AS KlarnaItem;

class ItemsSpec extends ObjectBehavior
{
    protected $currency = 'EUR';

    function let()
    {
        $this->beConstructedWith($this->currency);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Genesis\API\Request\Financial\Alternatives\Klarna\Items::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->toArray()->shouldNotBeEmpty();
    }

    public function it_can_calculate_amount()
    {
        $faker = \Faker\Factory::create();

        // item 1
        $quantity1     = $faker->numberBetween(1, 10);
        $unit_price1   = $faker->numberBetween(1, 20);
        $total_amount1 = $this->calculateTotalAmount($quantity1, $unit_price1);

        $item1 = new KlarnaItem(
            $faker->name,
            KlarnaItem::ITEM_TYPE_PHYSICAL,
            $quantity1,
            $unit_price1
        );

        $this->addItem($item1);

        // item 2
        $quantity2     = 1;
        $unit_price2   = 5;
        $total_amount2 = $this->calculateTotalAmount($quantity2, $unit_price2);

        $item2 = new KlarnaItem(
            $faker->name,
            KlarnaItem::ITEM_TYPE_PHYSICAL,
            $quantity2,
            $unit_price2
        );

        $this->addItem($item2);

        $this->getAmount()->shouldBe($total_amount1 + $total_amount2);
    }

    public function it_can_calculate_order_tax_amount()
    {
        $faker = \Faker\Factory::create();

        // item 1
        $quantity1         = $faker->numberBetween(1, 10);
        $unit_price1       = $faker->numberBetween(1, 20);
        $tax_rate1         = $faker->numberBetween(0, 100);
        $total_amount1     = $this->calculateTotalAmount($quantity1, $unit_price1);
        $total_tax_amount1 = $this->calculateTotalTaxAmount($total_amount1, $tax_rate1);

        $item1 = new KlarnaItem(
            $faker->name,
            KlarnaItem::ITEM_TYPE_PHYSICAL,
            $quantity1,
            $unit_price1,
            $tax_rate1
        );

        $this->addItem($item1);

        // item 2
        $quantity2         = $faker->numberBetween(1, 10);
        $unit_price2       = $faker->numberBetween(1, 20);
        $tax_rate2         = $faker->numberBetween(0, 100);
        $total_amount2     = $this->calculateTotalAmount($quantity2, $unit_price2);
        $total_tax_amount2 = $this->calculateTotalTaxAmount($total_amount2, $tax_rate2);

        $item2 = new KlarnaItem(
            $faker->name,
            KlarnaItem::ITEM_TYPE_PHYSICAL,
            $quantity2,
            $unit_price2,
            $tax_rate2
        );

        $this->addItem($item2);

        $this->getOrderTaxAmount()->shouldBe($total_tax_amount1 + $total_tax_amount2);
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $item = new KlarnaItem(
            $faker->name,
            KlarnaItem::ITEM_TYPE_PHYSICAL,
            $faker->numberBetween(1, 10),
            $faker->numberBetween(1, 20),
            $faker->numberBetween(0, 100)
        );

        $this->addItem($item);
    }

    protected function calculateTotalAmount($quantity, $unit_price, $total_discount_amount = 0)
    {
        return ($quantity * $unit_price) - $total_discount_amount;
    }

    protected function calculateTotalTaxAmount($total_amount, $tax_rate)
    {
        $total_amount = \Genesis\Utils\Currency::amountToExponent($total_amount, $this->currency);
        $tax_rate     = \Genesis\Utils\Currency::amountToExponent($tax_rate, $this->currency);

        $total_tax_amount = ceil(
            $total_amount - ($total_amount * 10000)/(10000 + $tax_rate)
        );

        return \Genesis\Utils\Currency::exponentToAmount($total_tax_amount, $this->currency);
    }

    public function getMatchers(): array
    {
        return [
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        ];
    }
}

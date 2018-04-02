<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\Klarna;

use PhpSpec\ObjectBehavior;

class ItemSpec extends ObjectBehavior
{
    function let()
    {
        $faker = \Faker\Factory::create();
        $this->beConstructedWith($faker->name, $this->ITEM_TYPE_PHYSICAL, $faker->numberBetween(1, 10), $faker->numberBetween(1, 20));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Genesis\API\Request\Financial\Alternatives\Klarna\Item::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->toArray()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_missing_required_name_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetName(null);
    }

    public function it_should_fail_when_missing_required_item_type_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetItemType(null);
    }

    public function it_should_fail_when_wrong_item_type_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetItemType('not-valid-item-type');
    }

    public function it_should_fail_when_missing_required_quantity_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetQuantity(null);
    }

    public function it_should_fail_when_missing_required_unit_price_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetUnitPrice(null);
    }

    public function it_should_fail_when_wrong_quantity_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetQuantity(-10);
    }

    public function it_should_fail_when_wrong_tax_rate_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetTaxRate(-10);
    }

    public function it_should_fail_when_wrong_total_discount_amount_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetTotalDiscountAmount(-10);
    }

    public function it_should_fail_when_wrong_quantity_unit_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetQuantityUnit('too-long-quantity-unit');
    }

    public function it_can_calculate_total_amount()
    {
        $this->setRequestParameters();

        $quantity              = 5;
        $unit_price            = 10;
        $total_discount_amount = 5;
        $total_amount          = $this->calculateTotalAmount($quantity, $unit_price, $total_discount_amount);

        $this->setQuantity($quantity);
        $this->setUnitPrice($unit_price);
        $this->setTotalDiscountAmount($total_discount_amount);

        $this->getTotalAmount()->shouldBe($total_amount);
    }

    public function it_can_calculate_total_tax_amount()
    {
        $this->setRequestParameters();

        $quantity              = 10;
        $unit_price            = 10;
        $tax_rate              = 21;
        $total_discount_amount = 5;
        $total_amount          = $this->calculateTotalAmount($quantity, $unit_price, $total_discount_amount);
        $total_tax_amount      = $this->calculateTotalTaxAmount($total_amount, $tax_rate);

        $this->setQuantity($quantity);
        $this->setUnitPrice($unit_price);
        $this->setTaxRate($tax_rate);
        $this->setTotalDiscountAmount($total_discount_amount);

        $this->getTotalTaxAmount()->shouldBe($total_tax_amount);
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setCurrency('EUR');

        $this->setTaxRate($faker->numberBetween(0, 100));
    }

    protected function calculateTotalAmount($quantity, $unit_price, $total_discount_amount = 0)
    {
        return ($quantity * $unit_price) - $total_discount_amount;
    }

    protected function calculateTotalTaxAmount($total_amount, $tax_rate)
    {
        $currency     = $this->getCurrency()->getWrappedObject();
        $total_amount = \Genesis\Utils\Currency::amountToExponent($total_amount, $currency);
        $tax_rate     = \Genesis\Utils\Currency::amountToExponent($tax_rate, $currency);

        $total_tax_amount = ceil(
            $total_amount - ($total_amount * 10000)/(10000 + $tax_rate)
        );

        return \Genesis\Utils\Currency::exponentToAmount($total_tax_amount, $currency);
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
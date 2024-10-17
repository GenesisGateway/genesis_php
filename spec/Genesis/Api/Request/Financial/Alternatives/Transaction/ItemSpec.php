<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives\Transaction;

use Faker\Factory;
use Genesis\Api\Constants\Financial\Alternative\Transaction\ItemTypes;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Item as InvoiceItem;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class ItemSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(InvoiceItem::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->toArray()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'name',
            'item_type',
        ]);
    }

    public function it_should_fail_when_wrong_item_type_param()
    {
        $this->setRequestParameters();
        $this->setItemType('not-valid-item-type');
        $this->shouldThrow()->during('getDocument');
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
        $unit_price            = 10.00;
        $total_discount_amount = 5.00;
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

    public function it_should_validate()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('validate');
    }

    public function it_should_throw_when_wrong_parameter()
    {
        $this->setRequestParameters();
        $this->setItemType('invalid-item-type');
        $this->shouldThrow()->during('validate');
    }

    protected function setRequestParameters()
    {
        $faker = Factory::create();

        $this->setName($faker->word);
        $this->setItemType(ItemTypes::PHYSICAL);
        $this->setQuantity($faker->numberBetween(1, 10));
        $this->setQuantityUnit('pcs');
        $this->setCurrency('EUR');
        $this->setUnitPrice($faker->numberBetween(1, 100));
        $this->setTaxRate($faker->numberBetween(0, 100));
    }

    protected function calculateTotalAmount($quantity, $unit_price, $total_discount_amount = 0)
    {
        return ($quantity * $unit_price) - $total_discount_amount;
    }

    protected function calculateTotalTaxAmount($total_amount, $tax_rate)
    {
        $currency     = $this->getCurrency()->getWrappedObject();
        $total_amount = Currency::amountToExponent($total_amount, $currency);
        $tax_rate     = Currency::amountToExponent($tax_rate, $currency);

        $total_tax_amount = ceil(
            $total_amount - ($total_amount * 10000)/(10000 + $tax_rate)
        );

        return Currency::exponentToAmount($total_tax_amount, $currency);
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

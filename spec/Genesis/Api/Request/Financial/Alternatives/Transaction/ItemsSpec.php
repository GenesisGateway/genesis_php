<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives\Transaction;

use Faker\Factory;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Items as InvoiceItems;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\Alternatives\Transaction\ItemsExample;

class ItemsSpec extends ObjectBehavior
{
    use ItemsExample;

    protected $currency = 'EUR';

    public function it_is_initializable()
    {
        $this->shouldHaveType(InvoiceItems::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->toArray()->shouldNotBeEmpty();
    }

    public function it_can_calculate_amount()
    {

        $item = $this->setItem();
        $item->setCurrency($this->currency);
        $quantity1     = $item->getQuantity();
        $unit_price1   = $item->getUnitPrice();
        $total_amount1 = $this->calculateTotalAmount($quantity1, $unit_price1);
        $this->addItem($item);

        // item 2
        $item = $this->setItem();
        $item->setCurrency($this->currency);
        $quantity2     = $item->getQuantity();
        $unit_price2   = $item->getUnitPrice();
        $total_amount2 = $this->calculateTotalAmount($quantity2, $unit_price2);
        $this->addItem($item);
        $this->getAmount()->shouldBe($total_amount1 + $total_amount2);
    }

    public function it_can_calculate_order_tax_amount()
    {
        $faker = Factory::create();

        $item = $this->setItem();
        $quantity1         = $item->getQuantity();
        $unit_price1       = $item->getUnitPrice();
        $tax_rate1         = $item->getTaxRate();
        $total_amount1     = $this->calculateTotalAmount($quantity1, $unit_price1);
        $total_tax_amount1 = $this->calculateTotalTaxAmount($total_amount1, $tax_rate1);
        $this->addItem($item);

        $item = $this->setItem();
        $quantity2         = $item->getQuantity();
        $unit_price2       = $item->getUnitPrice();
        $tax_rate2         = $item->getTaxRate();
        $total_amount2     = $this->calculateTotalAmount($quantity2, $unit_price2);
        $total_tax_amount2 = $this->calculateTotalTaxAmount($total_amount2, $tax_rate2);
        $this->addItem($item);

        $this->setCurrency('EUR');
        $this->getOrderTaxAmount()->shouldBe($total_tax_amount1 + $total_tax_amount2);
    }

    protected function setRequestParameters()
    {
        $item = $this->setItem();
        $this->setCurrency('EUR');
        $this->addItem($item);
    }

    protected function calculateTotalAmount($quantity, $unit_price, $total_discount_amount = 0)
    {
        return bcmul($quantity, $unit_price, 2) - $total_discount_amount;
    }

    protected function calculateTotalTaxAmount($total_amount, $tax_rate)
    {
        $total_amount = Currency::amountToExponent($total_amount, $this->currency);
        $tax_rate     = Currency::amountToExponent($tax_rate, $this->currency);

        $total_tax_amount = ceil(
            $total_amount - ($total_amount * 10000)/(10000 + $tax_rate)
        );

        return Currency::exponentToAmount($total_tax_amount, $this->currency);
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

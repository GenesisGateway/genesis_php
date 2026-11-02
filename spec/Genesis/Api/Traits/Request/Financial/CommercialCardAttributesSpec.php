<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidMethod;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\CommercialCardAttributesStub;

/**
 * Class CommercialCardAttributesSpec
 *
 * Specs the CommercialCardAttributes trait against CommercialCardAttributesStub: the setters and
 * getters, the Commercial Card Data validation (required fields, zero values, name or reference),
 * and the absence of an item_type setter (MagicAccessors throws InvalidMethod).
 *
 * @package spec\Genesis\Api\Traits\Request\Financial
 */
class CommercialCardAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CommercialCardAttributesStub::class);
    }

    public function it_should_return_null_for_commercial_card_fields_when_no_setter_called()
    {
        $this->getCommercialCardName()->shouldBeNull();
        $this->getCommercialCardReference()->shouldBeNull();
        $this->getCommercialCardQuantity()->shouldBeNull();
        $this->getCommercialCardUnitPrice()->shouldBeNull();
        $this->getCommercialCardTaxRate()->shouldBeNull();
        $this->getCommercialCardTotalTaxAmount()->shouldBeNull();
        $this->getCommercialCardTotalDiscountAmount()->shouldBeNull();
        $this->getCommercialCardCustomerCode()->shouldBeNull();
    }

    public function it_should_reject_commercial_card_name_above_max_length()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardName', [str_repeat('a', 36)]);
    }

    public function it_should_reject_commercial_card_reference_above_max_length()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardReference', [str_repeat('a', 16)]);
    }

    public function it_should_reject_commercial_card_customer_code_above_max_length()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardCustomerCode', [str_repeat('a', 18)]);
    }

    public function it_should_cast_commercial_card_quantity_min_string_to_int()
    {
        $this->setCommercialCardQuantity('1')->shouldReturn($this);
        $this->getCommercialCardQuantity()->shouldBe(1);
    }

    public function it_should_cast_commercial_card_quantity_max_string_to_int()
    {
        $this->setCommercialCardQuantity('9999999999')->shouldReturn($this);
        $this->getCommercialCardQuantity()->shouldBe(9999999999);
    }

    public function it_should_cast_commercial_card_quantity_leading_zero_string_to_int()
    {
        $this->setCommercialCardQuantity('0042')->shouldReturn($this);
        $this->getCommercialCardQuantity()->shouldBe(42);
    }

    public function it_should_reject_commercial_card_quantity_zero_string()
    {
        $this->assertCommercialCardQuantityRejected('0');
    }

    public function it_should_reject_commercial_card_quantity_above_max_string()
    {
        $this->assertCommercialCardQuantityRejected('10000000000');
    }

    public function it_should_accept_commercial_card_tax_rate_min_percent()
    {
        $this->setCommercialCardTaxRate(0.01)->shouldReturn($this);
        $this->getCommercialCardTaxRate()->shouldBe('0.01');
    }

    public function it_should_accept_commercial_card_tax_rate_max_percent()
    {
        $this->setCommercialCardTaxRate(99.99)->shouldReturn($this);
        $this->getCommercialCardTaxRate()->shouldBe('99.99');
    }

    public function it_should_store_commercial_card_tax_rate_float_as_string()
    {
        $this->setCommercialCardTaxRate(12.34)->shouldReturn($this);
        $this->getCommercialCardTaxRate()->shouldBe('12.34');
    }

    public function it_should_reject_commercial_card_tax_rate_zero()
    {
        $this->assertCommercialCardTaxRateRejected(0);
    }

    public function it_should_reject_commercial_card_tax_rate_hundred()
    {
        $this->assertCommercialCardTaxRateRejected(100);
    }

    public function it_should_reject_commercial_card_tax_rate_three_decimals()
    {
        $this->assertCommercialCardTaxRateRejected('12.345');
    }

    public function it_should_reject_commercial_card_tax_rate_boolean()
    {
        $this->assertCommercialCardTaxRateRejected(true);
    }

    public function it_should_reject_commercial_card_unit_price_non_numeric_string()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardUnitPrice', ['abc']);
    }

    public function it_should_reject_commercial_card_total_tax_amount_non_numeric_string()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardTotalTaxAmount', ['abc']);
    }

    public function it_should_reject_commercial_card_total_discount_amount_non_numeric_string()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardTotalDiscountAmount', ['abc']);
    }

    public function it_should_not_fail_commercial_card_validation_when_no_commercial_card_value_set()
    {
        $this->shouldNotThrow()->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_without_commercial_card_quantity()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardQuantity(null);

        $this->shouldThrow(new ErrorParameter('Empty (null) required parameter: commercial_card_quantity'))
            ->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_without_commercial_card_unit_price()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardUnitPrice(null);

        $this->shouldThrow(new ErrorParameter('Empty (null) required parameter: commercial_card_unit_price'))
            ->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_without_commercial_card_tax_rate()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardTaxRate(null);

        $this->shouldThrow(new ErrorParameter('Empty (null) required parameter: commercial_card_tax_rate'))
            ->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_without_commercial_card_total_tax_amount()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardTotalTaxAmount(null);

        $this->shouldThrow(
            new ErrorParameter('Empty (null) required parameter: commercial_card_total_tax_amount')
        )->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_without_commercial_card_total_discount_amount()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardTotalDiscountAmount(null);

        $this->shouldThrow(
            new ErrorParameter('Empty (null) required parameter: commercial_card_total_discount_amount')
        )->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_with_zero_commercial_card_unit_price()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardUnitPrice(0);

        $this->shouldThrow(new ErrorParameter('Empty (null) required parameter: commercial_card_unit_price'))
            ->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_pass_commercial_card_validation_with_zero_commercial_card_total_discount_amount()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardTotalDiscountAmount(0);

        $this->shouldNotThrow()->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_without_commercial_card_name_or_reference()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardName(null);

        $this->shouldThrow(
            new ErrorParameter(
                'commercial_card_name or commercial_card_reference is required when commercial card data is set.'
            )
        )->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_fail_commercial_card_validation_with_empty_commercial_card_name_and_reference()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardName('');
        $this->setCommercialCardReference('');

        $this->shouldThrow(
            new ErrorParameter(
                'commercial_card_name or commercial_card_reference is required when commercial card data is set.'
            )
        )->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_pass_commercial_card_validation_with_only_commercial_card_name()
    {
        $this->setCommercialCardRequiredFields();

        $this->shouldNotThrow()->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_pass_commercial_card_validation_with_only_commercial_card_reference()
    {
        $this->setCommercialCardRequiredFields();
        $this->setCommercialCardName('');
        $this->setCommercialCardReference('REF-1');

        $this->shouldNotThrow()->during('publicValidateCommercialCardAttributes');
    }

    public function it_should_not_have_commercial_card_item_type_setter()
    {
        $this->shouldThrow(InvalidMethod::class)
            ->during('setCommercialCardItemType', ['x']);
    }

    /**
     * Set a valid Commercial Card Data set: name, quantity, unit price, tax rate,
     * total tax amount, and total discount amount
     */
    protected function setCommercialCardRequiredFields()
    {
        $this->setCommercialCardName('Laptop');
        $this->setCommercialCardQuantity(2);
        $this->setCommercialCardUnitPrice('10');
        $this->setCommercialCardTaxRate('20');
        $this->setCommercialCardTotalTaxAmount('2');
        $this->setCommercialCardTotalDiscountAmount('0');
    }

    /**
     * Assert the quantity setter rejects a value whose integer cast is outside 1 to 9999999999
     * and keeps the previously accepted value.
     *
     * @param mixed $rejected
     */
    protected function assertCommercialCardQuantityRejected($rejected)
    {
        $this->setCommercialCardQuantity(7);

        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardQuantity', [$rejected]);
        $this->getCommercialCardQuantity()->shouldBe(7);
    }

    /**
     * Assert the tax rate setter rejects a value with the one tax rate message and keeps the
     * previously accepted value.
     *
     * @param mixed $rejected
     */
    protected function assertCommercialCardTaxRateRejected($rejected)
    {
        $this->setCommercialCardTaxRate('20');

        $this->shouldThrow(InvalidArgument::class)
            ->during('setCommercialCardTaxRate', [$rejected]);
        $this->getCommercialCardTaxRate()->shouldBe('20');
    }
}

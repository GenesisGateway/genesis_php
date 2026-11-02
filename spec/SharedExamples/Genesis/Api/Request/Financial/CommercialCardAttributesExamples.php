<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Request\Financial\Cards\Authorize3D;
use Genesis\Api\Request\Financial\Cards\Sale3D;
use Genesis\Api\Request\Financial\Refund;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Request-dependent commercial card examples shared by the Authorize, Authorize3D, Sale, Sale3D,
 * and Refund specs.
 *
 * These examples cover the Payload serialization and the request-level wiring: the commercial
 * card structure appended to the request, the validation called from checkRequirements(), the
 * commercial card entry merged into the zero-value whitelist, and the amounts converted by the
 * request transformAmount(). The setter and validation rules are tested once in
 * spec\Genesis\Api\Traits\Request\Financial\CommercialCardAttributesSpec.
 */
trait CommercialCardAttributesExamples
{
    public function it_should_build_commercial_card_item_with_all_fields_in_order()
    {
        $this->setRequestParameters();
        $this->setCurrency('EUR');

        $this->setCommercialCardName('Laptop');
        $this->setCommercialCardReference('SKU-1');
        $this->setCommercialCardQuantity('2');
        $this->setCommercialCardUnitPrice('1250.50');
        $this->setCommercialCardTaxRate('12.34');
        $this->setCommercialCardTotalTaxAmount('416.83');
        $this->setCommercialCardTotalDiscountAmount('10.00');
        $this->setCommercialCardCustomerCode('CUST-17');

        $this->getDocument()->shouldMatch(
            '/<items>\s*<item>\s*' .
            '<item_type>commercial_card<\/item_type>\s*' .
            '<name>Laptop<\/name>\s*' .
            '<reference>SKU-1<\/reference>\s*' .
            '<quantity>2<\/quantity>\s*' .
            '<unit_price>125050<\/unit_price>\s*' .
            '<tax_rate>1234<\/tax_rate>\s*' .
            '<total_tax_amount>41683<\/total_tax_amount>\s*' .
            '<total_discount_amount>1000<\/total_discount_amount>\s*' .
            '<merchant_data>\s*<customer_code>CUST-17<\/customer_code>\s*<\/merchant_data>\s*' .
            '<\/item>\s*<\/items>/'
        );
    }

    public function it_should_not_build_commercial_card_items_when_no_setter_called()
    {
        $this->setRequestParameters();
        $this->setCurrency('EUR');

        $this->getDocument()->shouldNotContain('<items>');
        $this->getDocument()->shouldNotContain('<total_discount_amount>');
    }

    public function it_should_leave_document_unchanged_when_fields_empty_or_null()
    {
        $this->setRequestParameters();
        $this->setCurrency('EUR');

        $before = $this->getDocument()->getWrappedObject();

        $this->setCommercialCardName('');
        $this->setCommercialCardReference('');
        $this->setCommercialCardCustomerCode('');
        $this->setCommercialCardQuantity(null);
        $this->setCommercialCardUnitPrice(null);
        $this->setCommercialCardTaxRate(null);
        $this->setCommercialCardTotalTaxAmount(null);
        $this->setCommercialCardTotalDiscountAmount(null);

        $this->getDocument()->shouldBe($before);
        $this->getDocument()->shouldNotContain('<items>');
    }

    public function it_should_leave_rest_of_document_unchanged_with_valid_commercial_data()
    {
        $this->setRequestParameters();
        $this->setCurrency('EUR');

        $before = $this->getDocument()->getWrappedObject();

        $this->setCommercialCardFixedValidData();

        $withItems = $this->getDocument()->getWrappedObject();
        $withoutItems = preg_replace('/\n\s*<items>.*<\/items>/s', '', $withItems);

        if ($withoutItems !== $before) {
            throw new \Exception('Commercial card data changed the rest of the document.');
        }
    }

    public function it_should_keep_zero_commercial_card_total_discount_amount_string()
    {
        $this->assertCommercialCardZeroTotalDiscountAmount('0');
    }

    public function it_should_require_commercial_card_quantity()
    {
        $this->setCommercialCardValidParameters(false);
        $this->setCommercialCardQuantity(null);

        $this->shouldThrow(
            new ErrorParameter('Empty (null) required parameter: commercial_card_quantity')
        )->during('getDocument');
    }

    public function it_should_serialize_commercial_card_tax_rate_small_fraction()
    {
        $this->setCommercialCardValidParameters(false);
        $this->setCommercialCardTaxRate('0.05');
        $this->getDocument()->shouldContain('<tax_rate>5</tax_rate>');
    }

    public function it_should_serialize_commercial_card_tax_rate_independent_of_currency_jpy()
    {
        $this->setCommercialCardValidParameters(false, 'JPY');
        $this->setCommercialCardTaxRate('12.34');

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain('<tax_rate>1234</tax_rate>');
    }

    public function it_should_serialize_commercial_card_unit_price_minor_units_bhd()
    {
        $this->setCommercialCardValidParameters(false, 'BHD');
        $this->setCommercialCardUnitPrice('1.234');

        $this->getDocument()->shouldContain('<unit_price>1234</unit_price>');
    }

    public function it_should_throw_invalid_argument_for_too_many_decimals_eur()
    {
        $this->setCommercialCardValidParameters(false);
        $this->setCommercialCardUnitPrice('12.345');

        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_should_keep_zero_value_whitelist_with_commercial_data()
    {
        if ($this->getWrappedObject() instanceof Refund) {
            $this->setRequestParameters();
            $this->setCurrency('EUR');
            $this->setAmount(0);

            $this->shouldThrow(
                new ErrorParameter('Empty (null) required parameter: amount')
            )->during('getDocument');

            return;
        }

        $this->setCommercialCardValidParameters();
        $this->setAmount(0);

        if ($this->isCommercialCardThreedsHost()) {
            $this->setThreedsV2BrowserTimeZoneOffset(0);
            $this->getDocument()->shouldContain('<time_zone_offset>0</time_zone_offset>');
        }

        $this->getDocument()->shouldContain('<amount>0</amount>');
    }

    /**
     * Whether the host request is a 3D card request that emits browser attributes.
     *
     * @return bool
     */
    protected function isCommercialCardThreedsHost()
    {
        return $this->getWrappedObject() instanceof Authorize3D
            || $this->getWrappedObject() instanceof Sale3D;
    }

    /**
     * Assert that a zero total_discount_amount is kept in the payload and raises no exception.
     *
     * @param int|string $zero
     */
    protected function assertCommercialCardZeroTotalDiscountAmount($zero)
    {
        $this->setCommercialCardValidParameters(false);
        $this->setCommercialCardTotalDiscountAmount($zero);

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain('<total_discount_amount>0</total_discount_amount>');
    }

    /**
     * Set a complete, valid set of commercial card fields on the request, with EUR by default.
     *
     * @param bool   $withCustomerCode Whether to also set the optional customer code
     * @param string $currency         The request currency to use
     */
    protected function setCommercialCardValidParameters($withCustomerCode = true, $currency = 'EUR')
    {
        $this->setRequestParameters();
        $this->setCurrency($currency);

        $this->setCommercialCardFixedValidData($withCustomerCode);
    }

    /**
     * Set a complete, valid set of commercial card fields only, without touching the base
     * request parameters. Amounts are whole-number major units so they are valid for any
     * currency exponent.
     *
     * @param bool $withCustomerCode Whether to also set the optional customer code
     */
    protected function setCommercialCardFixedValidData($withCustomerCode = false)
    {
        $this->setCommercialCardName('Laptop');
        $this->setCommercialCardReference('SKU-1');
        $this->setCommercialCardQuantity('2');
        $this->setCommercialCardUnitPrice('10');
        $this->setCommercialCardTaxRate('20');
        $this->setCommercialCardTotalTaxAmount('2');
        $this->setCommercialCardTotalDiscountAmount('0');

        if ($withCustomerCode) {
            $this->setCommercialCardCustomerCode('CUST-17');
        }
    }
}

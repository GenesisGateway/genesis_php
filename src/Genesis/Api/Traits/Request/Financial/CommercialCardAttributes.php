<?php

/**
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\Financial;

use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait CommercialCardAttributes
 * @package Genesis\Api\Traits\Request\Financial
 *
 * Commercial Card Data (Mastercard Large Ticket Interchange). Optional, clearing only.
 *
 * @method string     getCommercialCardName()
 * @method string     getCommercialCardReference()
 * @method int        getCommercialCardQuantity()
 * @method string     getCommercialCardUnitPrice()           Major currency units
 * @method string     getCommercialCardTaxRate()             Percent as a string, e.g. '12.34'
 * @method string     getCommercialCardTotalTaxAmount()      Major currency units
 * @method string     getCommercialCardTotalDiscountAmount() Major currency units
 * @method string     getCommercialCardCustomerCode()
 */
trait CommercialCardAttributes
{
    /**
     * Item Description
     *
     * @var string
     */
    protected $commercial_card_name;

    /**
     * Product Code
     *
     * @var string
     */
    protected $commercial_card_reference;

    /**
     * Item quantity
     *
     * @var int
     */
    protected $commercial_card_quantity;

    /**
     * Item unit price in major currency units
     *
     * @var string
     */
    protected $commercial_card_unit_price;

    /**
     * Tax rate as a percent, e.g. '12.34'
     *
     * @var string
     */
    protected $commercial_card_tax_rate;

    /**
     * Total tax amount in major currency units
     *
     * @var string
     */
    protected $commercial_card_total_tax_amount;

    /**
     * Total discount amount in major currency units
     *
     * @var string
     */
    protected $commercial_card_total_discount_amount;

    /**
     * Merchant customer code
     *
     * @var string
     */
    protected $commercial_card_customer_code;

    /**
     * Set the Item Description
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardName($value)
    {
        return $this->setLimitedString('commercial_card_name', $value, null, 35);
    }

    /**
     * Set the Product Code
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardReference($value)
    {
        return $this->setLimitedString('commercial_card_reference', $value, null, 15);
    }

    /**
     * Set the Merchant customer code
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardCustomerCode($value)
    {
        return $this->setLimitedString('commercial_card_customer_code', $value, null, 17);
    }

    /**
     * Set the Item quantity
     *
     * @param int $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardQuantity($value)
    {
        if ($value === null) {
            $this->commercial_card_quantity = null;

            return $this;
        }

        $quantity = (int) $value;

        if ($quantity < 1 || $quantity > 9999999999) {
            throw new InvalidArgument(
                'Invalid value for commercial_card_quantity. Values between 1 and 9999999999 are accepted'
            );
        }

        $this->commercial_card_quantity = $quantity;

        return $this;
    }

    /**
     * Set the Item unit price in major currency units
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardUnitPrice($value)
    {
        return $this->parseAmount('commercial_card_unit_price', $value);
    }

    /**
     * Set the Tax rate as a percent, e.g. '12.34'
     *
     * @param int|float|string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardTaxRate($value)
    {
        if ($value === null) {
            $this->commercial_card_tax_rate = null;

            return $this;
        }

        $percent = is_scalar($value) && !is_bool($value) ? (string) $value : '';

        if (!(preg_match('/^\d{1,2}(\.\d{1,2})?$/D', $percent) && $percent > 0)) {
            throw new InvalidArgument(
                'commercial_card_tax_rate must be a percent between 0.01 and 99.99 with up to two decimal places.'
            );
        }

        $this->commercial_card_tax_rate = $percent;

        return $this;
    }

    /**
     * Set the Total tax amount in major currency units
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardTotalTaxAmount($value)
    {
        return $this->parseAmount('commercial_card_total_tax_amount', $value);
    }

    /**
     * Set the Total discount amount in major currency units
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCommercialCardTotalDiscountAmount($value)
    {
        return $this->parseAmount('commercial_card_total_discount_amount', $value);
    }

    /**
     * Commercial Card Data structure
     *
     * item_type is always commercial_card: the gateway defines no other item type for this item,
     * so the value is fixed here and no setter or property exists for it.
     *
     * @return array Empty when no commercial card value is set
     */
    protected function getCommercialCardAttributesStructure()
    {
        if (!$this->isCommercialCardDataSupplied()) {
            return [];
        }

        return [
            'items' => [
                'item' => [
                    'item_type'             => 'commercial_card',
                    'name'                  => $this->commercial_card_name,
                    'reference'             => $this->commercial_card_reference,
                    'quantity'              => $this->commercial_card_quantity,
                    'unit_price'            => $this->transformAmount(
                        $this->commercial_card_unit_price,
                        $this->currency
                    ),
                    'tax_rate'              => $this->commercial_card_tax_rate !== null
                        ? bcmul($this->commercial_card_tax_rate, '100', 0)
                        : null,
                    'total_tax_amount'      => $this->transformAmount(
                        $this->commercial_card_total_tax_amount,
                        $this->currency
                    ),
                    'total_discount_amount' => $this->transformAmount(
                        $this->commercial_card_total_discount_amount,
                        $this->currency
                    ),
                    'merchant_data'         => [
                        'customer_code' => $this->commercial_card_customer_code
                    ]
                ]
            ]
        ];
    }

    /**
     * Zero-value whitelist entries for the Commercial Card Data
     *
     * Merged by each request into allowedEmptyNotNullFields() so that a zero total_discount_amount
     * is kept in the request tree and passes the required-field check.
     *
     * @return array
     */
    protected function getCommercialCardAllowedFieldsZeroValues()
    {
        return [
            'commercial_card_total_discount_amount' => 'total_discount_amount'
        ];
    }

    /**
     * Validate the Commercial Card Data. No-op when no commercial card value is set.
     *
     * @return void
     * @throws ErrorParameter
     */
    protected function validateCommercialCardAttributes()
    {
        if (!$this->isCommercialCardDataSupplied()) {
            return;
        }

        $requiredFields = [
            'commercial_card_quantity',
            'commercial_card_unit_price',
            'commercial_card_tax_rate',
            'commercial_card_total_tax_amount',
            'commercial_card_total_discount_amount'
        ];

        $allowedEmptyFields = $this->allowedEmptyNotNullFields();

        foreach ($requiredFields as $field) {
            if (isset($allowedEmptyFields[$field]) && $this->{$field} !== null) {
                // Bypass Not Null but Empty value evaluation allowed like 0
                continue;
            }

            if (empty($this->{$field})) {
                throw new ErrorParameter(sprintf('Empty (null) required parameter: %s', $field));
            }
        }

        $this->validateCommercialCardDescription();
    }

    /**
     * Require at least one of the item description (name) or product code (reference)
     *
     * @return void
     * @throws ErrorParameter
     */
    protected function validateCommercialCardDescription()
    {
        $name      = $this->commercial_card_name;
        $reference = $this->commercial_card_reference;

        if (($name === null || $name === '') && ($reference === null || $reference === '')) {
            throw new ErrorParameter(
                'commercial_card_name or commercial_card_reference is required when commercial card data is set.'
            );
        }
    }

    /**
     * Whether any Commercial Card Data value has been supplied
     *
     * A field counts as supplied when it is neither null nor an empty string, so 0, '0', and '0.00'
     * are treated as supplied.
     *
     * @return bool
     */
    protected function isCommercialCardDataSupplied()
    {
        $fields = [
            $this->commercial_card_name,
            $this->commercial_card_reference,
            $this->commercial_card_quantity,
            $this->commercial_card_unit_price,
            $this->commercial_card_tax_rate,
            $this->commercial_card_total_tax_amount,
            $this->commercial_card_total_discount_amount,
            $this->commercial_card_customer_code
        ];

        foreach ($fields as $value) {
            if ($value !== null && $value !== '') {
                return true;
            }
        }

        return false;
    }
}

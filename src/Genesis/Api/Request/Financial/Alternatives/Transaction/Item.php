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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Financial\Alternatives\Transaction;

use Genesis\Api\Constants\Financial\Alternative\Transaction\ItemTypes;
use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Validations\Request\Validations;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency as CurrencyUtils;

/**
 * Class Item
 *
 * Alternative payment method
 *
 * @package Genesis\Api\Request\Financial\Alternatives\Transaction\Invoice
 *
 * @method $this  setReference($value)           Set reference
 * @method $this  setImageUrl($value)            Set image url
 * @method $this  setProductUrl($value)          Set product url
 * @method $this  setCurrency($value)            Set currency
 * @method $this  setName($value)                Set name
 * @method $this  setItemType($value)            Set item type
 * @method string getCurrency()                  Get currency
 * @method string getItemType()                  Get item type
 * @method int    getQuantity()                  Get quantity
 * @method int    getUnitPrice()                 Get unit price
 * @method string getReference()                 Get reference
 * @method string getName()                      Get name
 * @method int    getTaxRate()                   Get tax rate
 * @method int    getTotalDiscountAmount()       Get total discount amount
 * @method string getImageUrl()                  Get image url
 * @method string getProductUrl()                Get product url
 * @method string getQuantityUnit()              Get quantity unit
 * @method array  getProductIdentifiers()        Get product identifiers
 * @method array  getMarketplaceSellerInfo()     Get marketplace seller info
 */
class Item
{
    use MagicAccessors;
    use Validations {
        Validations::validate as protected traitValidate;
    }

    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

    /**
     * Item type
     *
     * @var string
     */
    protected $item_type;

    /**
     * Item quantity
     *
     * @var int
     */
    protected $quantity;

    /**
     * Item unit price
     *
     * @var int
     */
    protected $unit_price;

    /**
     * Item reference(SKU or similar)
     *
     * @var string
     */
    protected $reference = '';

    /**
     * Descriptive item name.
     *
     * @var string
     */
    protected $name;

    /**
     * Item tax rate( in percentage)
     *
     * @var int
     */
    protected $tax_rate = 0;

    /**
     * Item total discount amount. Includes tax
     *
     * @var int
     */
    protected $total_discount_amount = 0;

    /**
     * Item image url
     *
     * @var string
     */
    protected $image_url = '';

    /**
     * Item product url
     *
     * @var string
     */
    protected $product_url = '';

    /**
     * Item quantity unit (kg, pcs...)
     *
     * @var string
     */
    protected $quantity_unit = '';

    /**
     * Item product identifiers:brand
     *
     * @var ProductIdentifiers
     */
    protected $product_identifiers;

    /**
     * Item merchant data: marketplace_seller_info
     *
     * @var array
     */
    protected $marketplace_seller_info = [];

    /**
     * Item constructor. Set required fields
     */
    public function __construct()
    {
        $this->setRequiredFields();
    }

    /**
     * Set quantity
     *
     * @param $value
     *
     * @return $this
     *
     * @throws ErrorParameter|InvalidArgument
     */
    public function setQuantity($value)
    {
        $this->verifyRequiredField('quantity', $value);
        $this->verifyNonNegativeField('quantity', $value);
        $this->quantity = $value;

        return $this;
    }

    /**
     * Set unit price
     *
     * @param $value
     *
     * @return $this
     *
     * @throws ErrorParameter
     */
    public function setUnitPrice($value)
    {
        $this->verifyUnitPriceField($value);
        $this->unit_price = $value;

        return $this;
    }

    /**
     * Set tax rate
     *
     * @param $value
     *
     * @return $this
     *
     * @throws ErrorParameter
     */
    public function setTaxRate($value)
    {
        $this->verifyNonNegativeField('tax_rate', $value);
        $this->tax_rate = $value;

        return $this;
    }

    /**
     * Set item quantity unit
     *
     * @param $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setQuantityUnit($value)
    {
        if (!empty($value) && strlen($value) > 8) {
            throw new InvalidArgument(
                sprintf(
                    'Item parameter quantity_unit is set to %s, but expected to be string with max length 8 characters',
                    $value
                )
            );
        }
        $this->quantity_unit = $value;

        return $this;
    }

    /**
     * Set total discount amount
     *
     * @param $value
     *
     * @return $this
     *
     * @throws ErrorParameter
     */
    public function setTotalDiscountAmount($value)
    {
        $this->verifyNonNegativeField('total_discount_amount', $value);
        $this->total_discount_amount = $value;

        return $this;
    }

    /**
     * Set product identifiers
     *
     * @param ProductIdentifiers $value
     *
     * @return $this
     */
    public function setProductIdentifiers(ProductIdentifiers $value)
    {
        $this->product_identifiers = $value;

        return $this;
    }

    /**
     * Add merchant data: marketplace seller info
     *
     * @param string $value
     *
     * @return $this
     */
    public function addMerchantMarketplaceSellerInfo($value)
    {
        $this->marketplace_seller_info[] = $value;

        return $this;
    }

    /**
     * Calculate order item total amount
     *
     * @return int
     */
    public function getTotalAmount()
    {
        $exp          = CurrencyUtils::fetchCurrencyExponent($this->currency);
        $total_amount = bcmul($this->unit_price, $this->quantity, $exp);

        if (!empty($this->total_discount_amount)) {
            return $total_amount - $this->total_discount_amount;
        }

        return $total_amount;
    }

    /**
     * Calculate order item total tax amount.
     * Round it up to next whole number
     *
     * @return false|float|string
     *
     * @throws InvalidArgument
     */
    public function getTotalTaxAmount()
    {
        // Convert to minor units for more accurate calculations
        $total_amount = $this->getAmountInProperUnit($this->getTotalAmount());
        $tax_rate     = $this->getAmountInProperUnit($this->tax_rate);

        $total_tax_amount = ceil(
            $total_amount - (($total_amount * 10000) / (10000 + $tax_rate))
        );

        if (!empty($this->currency)) {
            return CurrencyUtils::exponentToAmount($total_tax_amount, $this->currency);
        }

        return $total_tax_amount;
    }

    /**
     * Convert item to array
     *
     * @return array
     *
     * @throws InvalidArgument
     */
    public function toArray()
    {
        return [
            'name'                  => $this->name,
            'item_type'             => $this->item_type,
            'quantity'              => $this->quantity,
            'unit_price'            => $this->getAmountInProperUnit($this->unit_price),
            'tax_rate'              => $this->getAmountInProperUnit($this->tax_rate),
            'total_discount_amount' => $this->getAmountInProperUnit($this->total_discount_amount),
            'total_amount'          => $this->getAmountInProperUnit($this->getTotalAmount()),
            'total_tax_amount'      => $this->getAmountInProperUnit($this->getTotalTaxAmount()),
            'reference'             => $this->reference,
            'image_url'             => $this->image_url,
            'product_url'           => $this->product_url,
            'quantity_unit'         => $this->quantity_unit,
            'product_identifiers'   => $this->getProductIdentifiersParamsStructure(),
            'merchant_data'         => $this->getMerchantDataParamsStructure()
        ];
    }

    /**
     * Check for required fields
     *
     * @return void
     *
     */
    public function validate()
    {
        $this->traitValidate();
    }

    /**
     * Builds an array list with all product identifiers params
     *
     * @return array
     */
    protected function getProductIdentifiersParamsStructure()
    {
        if ($this->product_identifiers instanceof ProductIdentifiers) {
            return $this->product_identifiers->toArray();
        }

        return [];
    }

    /**
     * Builds an array list with all merchant data params
     *
     * @return array
     */
    protected function getMerchantDataParamsStructure()
    {
        return array_map(
            function ($marketplace_seller_info) {
                return ['marketplace_seller_info' => $marketplace_seller_info];
            },
            $this->marketplace_seller_info
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'name',
            'item_type',
            'quantity',
            'unit_price'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'item_type' => ItemTypes::getAll()
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Verify non-negative filed
     *
     * @param $field
     * @param $value
     *
     * @throws InvalidArgument
     */
    protected function verifyNonNegativeField($field, $value)
    {
        if (!empty($value) && $value <= 0) {
            throw new InvalidArgument(
                sprintf(
                    'Item parameter %s is set to %s, but expected to be positive number',
                    $field,
                    $value
                )
            );
        }
    }

    /**
     * Verify negative filed
     *
     * @param $field
     * @param $value
     *
     * @throws ErrorParameter|InvalidArgument
     */
    protected function verifyNegativeField($field, $value)
    {
        if (!empty($value) && $value > 0) {
            throw new InvalidArgument(
                sprintf(
                    'Item parameter %s is set to %s, but expected to be negative number',
                    $field,
                    $value
                )
            );
        }
    }

    /**
     * Verify unit_price filed
     *
     * @param $value
     *
     * @throws ErrorParameter|InvalidArgument
     */
    protected function verifyUnitPriceField($value)
    {
        $this->verifyRequiredField('unit_price', $value);

        if (in_array($this->item_type, [ItemTypes::DISCOUNT, ItemTypes::STORE_CREDIT])) {
            $this->verifyNegativeField('unit_price', $value);

            return;
        }

        $this->verifyNonNegativeField('unit_price', $value);
    }

    /**
     * Verify required field
     *
     * @param $field
     * @param $value
     *
     * @throws InvalidArgument
     */
    protected function verifyRequiredField($field, $value)
    {
        if (empty($value)) {
            throw new InvalidArgument(
                sprintf(
                    'Empty (null) item required parameter: %s',
                    $field
                )
            );
        }
    }

    /**
     * If the currency is set and the amount is in major unit convert it to minor
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws InvalidArgument
     */
    private function getAmountInProperUnit($value)
    {
        if (!empty($this->currency)) {
            return CurrencyUtils::amountToExponent($value, $this->currency);
        }

        return $value;
    }
}

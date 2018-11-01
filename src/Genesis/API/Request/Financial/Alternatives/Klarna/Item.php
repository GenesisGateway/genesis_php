<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Financial\Alternatives\Klarna;

use Genesis\API\Traits\MagicAccessors;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency as CurrencyUtils;

/**
 * Class Item
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives\Klarna
 *
 * @method $this setReference($value) Set reference
 * @method $this setImageUrl($value) Set image url
 * @method $this setProductUrl($value) Set product url
 */
class Item
{
    use MagicAccessors;

    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

    /**
     * Item type
     * @var string
     */
    protected $item_type;

    /**
     * Item quantity
     * @var int
     */
    protected $quantity;

    /**
     * Item unit price
     * @var int
     */
    protected $unit_price;

    /**
     * Item reference(SKU or similar)
     * @var string
     */
    protected $reference;

    /**
     * Descriptive item name.
     * @var string
     */
    protected $name;

    /**
     * Item tax rate( in percentage)
     * @var int
     */
    protected $tax_rate = 0;

    /**
     * Item total discount amount. Includes tax
     * @var int
     */
    protected $total_discount_amount = 0;

    /**
     * Item image url
     * @var string
     */
    protected $image_url;

    /**
     * Item product url
     * @var string
     */
    protected $product_url;

    /**
     * Item quantity unit (kg, pcs...)
     * @var string
     */
    protected $quantity_unit;

    /**
     * Item product identifiers:brand
     * @var array
     */
    protected $product_identifiers;

    /**
     * Item merchant data: marketplace_seller_info
     * @var array
     */
    protected $marketplace_seller_info = [];

    /**
     * Item type physical
     * @const string
     */
    const ITEM_TYPE_PHYSICAL = 'physical';

    /**
     * Item type discount
     * @const string
     */
    const ITEM_TYPE_DISCOUNT = 'discount';

    /**
     * Item type shipping_fee
     * @const string
     */
    const ITEM_TYPE_SHIPPING_FEE = 'shipping_fee';

    /**
     * Item type digital
     * @const string
     */
    const ITEM_TYPE_DIGITAL = 'digital';

    /**
     * Item type gift_card
     * @const string
     */
    const ITEM_TYPE_GIFT_CARD = 'gift_card';

    /**
     * Item type store_credit
     * @const string
     */
    const ITEM_TYPE_STORE_CREDIT = 'store_credit';

    /**
     * Item type surcharge
     * @const string
     */
    const ITEM_TYPE_SURCHARGE = 'surcharge';

    /**
     * Item constructor.
     * @param $name
     * @param $item_type
     * @param $quantity
     * @param $unit_price
     * @param $reference
     * @param $tax_rate
     * @param $total_discount_amount
     * @param $image_url
     * @param $product_url
     * @param $quantity_unit
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function __construct(
        $name,
        $item_type,
        $quantity,
        $unit_price,
        $tax_rate = 0,
        $total_discount_amount = 0,
        $reference = '',
        $image_url = '',
        $product_url = '',
        $quantity_unit = ''
    ) {
        $this->setName($name);
        $this->setItemType($item_type);
        $this->setQuantity($quantity);
        $this->setUnitPrice($unit_price);
        $this->setTaxRate($tax_rate);
        $this->setTotalDiscountAmount($total_discount_amount);
        $this->setReference($reference);
        $this->setImageUrl($image_url);
        $this->setProductUrl($product_url);
        $this->setQuantityUnit($quantity_unit);
    }

    /**
     * Verify required field
     *
     * @param $field
     * @param $value
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyRequiredField($field, $value)
    {
        if (empty($value)) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'Empty (null) item required parameter: %s',
                    $field
                )
            );
        }
    }

    /**
     * Verify non-negative filed
     *
     * @param $field
     * @param $value
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyNonNegativeField($field, $value)
    {
        if (!empty($value) && $value <= 0) {
            throw new \Genesis\Exceptions\ErrorParameter(
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
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyNegativeField($field, $value)
    {
        if (!empty($value) && $value > 0) {
            throw new \Genesis\Exceptions\ErrorParameter(
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
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyUnitPriceField($value)
    {
        $this->verifyRequiredField('unit_price', $value);

        if (in_array($this->item_type, [self::ITEM_TYPE_DISCOUNT, self::ITEM_TYPE_STORE_CREDIT])) {
            $this->verifyNegativeField('unit_price', $value);
            return;
        }
        
        $this->verifyNonNegativeField('unit_price', $value);
    }

    /**
     * Set name
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function setName($value)
    {
        $this->verifyRequiredField('name', $value);

        $this->name = $value;
        return $this;
    }

    /**
     * Set unit price
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function setUnitPrice($value)
    {
        $this->verifyUnitPriceField($value);

        $this->unit_price = $value;
        return $this;
    }

    /**
     * Set quantity
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function setQuantity($value)
    {
        $this->verifyRequiredField('quantity', $value);
        $this->verifyNonNegativeField('quantity', $value);

        $this->quantity = $value;
        return $this;
    }

    /**
     * Set tax rate
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function setTaxRate($value)
    {
        $this->verifyNonNegativeField('tax_rate', $value);

        $this->tax_rate = $value;
        return $this;
    }

    /**
     * Set total discount amount
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function setTotalDiscountAmount($value)
    {
        $this->verifyNonNegativeField('total_discount_amount', $value);

        $this->total_discount_amount = $value;
        return $this;
    }

    /**
     * Set item type
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function setItemType($value)
    {
        $this->verifyRequiredField('item_type', $value);

        // check if it is valid type
        $item_types = array(
            self::ITEM_TYPE_PHYSICAL,
            self::ITEM_TYPE_DISCOUNT,
            self::ITEM_TYPE_SHIPPING_FEE,
            self::ITEM_TYPE_DIGITAL,
            self::ITEM_TYPE_GIFT_CARD,
            self::ITEM_TYPE_STORE_CREDIT,
            self::ITEM_TYPE_SURCHARGE
        );
        if (!in_array($value, $item_types)) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'Required item parameter item_type is set to %s, but expected to be one of (%s)',
                    $value,
                    implode(
                        ', ',
                        CommonUtils::getSortedArrayByValue($item_types)
                    )
                )
            );
        }

        $this->item_type = $value;
        return $this;
    }

    /**
     * Set item quantity unit
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function setQuantityUnit($value)
    {
        if (!empty($value) && strlen($value) > 8) {
            throw new \Genesis\Exceptions\ErrorParameter(
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
     * Calculate order item total amount
     *
     * @return integer
     */
    public function getTotalAmount()
    {
        $total_amount = $this->unit_price * $this->quantity;

        if (!empty($this->total_discount_amount)) {
            return $total_amount - $this->total_discount_amount;
        }
        return $total_amount;
    }

    /**
     * Calculate order item total tax amount.
     * Round it up to next whole number
     *
     * @return integer
     */
    public function getTotalTaxAmount()
    {
        // Convert to minor units for more accurate calculations
        $total_amount = CurrencyUtils::amountToExponent($this->getTotalAmount(), $this->currency);
        $tax_rate     = CurrencyUtils::amountToExponent($this->tax_rate, $this->currency);

        $total_tax_amount = ceil(
            $total_amount - ( ($total_amount * 10000) / (10000 + $tax_rate) )
        );

        return CurrencyUtils::exponentToAmount($total_tax_amount, $this->currency);
    }

    /**
     * Convert item to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'                  => $this->name,
            'item_type'             => $this->item_type,
            'quantity'              => $this->quantity,
            'unit_price'            => CurrencyUtils::amountToExponent($this->unit_price, $this->currency),
            'tax_rate'              => CurrencyUtils::amountToExponent($this->tax_rate, $this->currency),
            'total_discount_amount' => CurrencyUtils::amountToExponent($this->total_discount_amount, $this->currency),
            'total_amount'          => CurrencyUtils::amountToExponent($this->getTotalAmount(), $this->currency),
            'total_tax_amount'      => CurrencyUtils::amountToExponent($this->getTotalTaxAmount(), $this->currency),
            'reference'             => $this->reference,
            'image_url'             => $this->image_url,
            'product_url'           => $this->product_url,
            'quantity_unit'         => $this->quantity_unit,
            'product_identifiers'   => $this->getProductIdentifiersParamsStructure(),
            'merchant_data'         => $this->getMerchantDataParamsStructure()
        ];
    }

    /**
     * Set product identifiers
     *
     * @param ProductIdentifiers $value
     * @return $this
     */
    public function setProductIdentifiers(ProductIdentifiers $value)
    {
        $this->product_identifiers = $value;
        return $this;
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
     * Add merchant data: marketplace seller info
     *
     * @param $value
     * @return $this
     */
    public function addMerchantMarketplaceSellerInfo($value)
    {
        array_push($this->marketplace_seller_info, $value);
        return $this;
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
}

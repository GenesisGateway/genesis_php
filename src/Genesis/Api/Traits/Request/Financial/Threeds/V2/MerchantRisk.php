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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\DeliveryTimeframes;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\PreOrderPurchaseIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ReorderItemIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ShippingIndicators;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * Trait MerchantRisk
 * @package Genesis\Api\Traits\Request\Financial\Threeds\V2
 *
 * @codingStandardsIgnoreStart
 * @method string getThreedsV2MerchantRiskShippingIndicator()               Indicator code that most accurately describes the shipping method
 * @method $this  setThreedsV2MerchantRiskShippingIndicator($value)         Indicator code that most accurately describes the shipping method
 * @method string getThreedsV2MerchantRiskDeliveryTimeframe()               Indicates the merchandise delivery timeframe
 * @method $this  setThreedsV2MerchantRiskDeliveryTimeframe($value)         Indicates the merchandise delivery timeframe
 * @method string getThreedsV2MerchantRiskReorderItemsIndicator()           Indicates whether the cardholder is reordering previously purchased merchandise
 * @method $this  setThreedsV2MerchantRiskReorderItemsIndicator($value)     Indicates whether the cardholder is reordering previously purchased merchandise
 * @method string getThreedsV2MerchantRiskPreOrderPurchaseIndicator()       Indicates whether cardholder is placing an order for merchandise with a future-availability or release date
 * @method $this  setThreedsV2MerchantRiskPreOrderPurchaseIndicator($value) Indicates whether cardholder is placing an order for merchandise with a future-availability or release date
 * @method bool   getThreedsV2MerchantRiskGiftCard()                        Prepaid or gift card purchase
 * @method int    getThreedsV2MerchantRiskGiftCardCount()                   For prepaid or gift card purchase, total count of individual prepaid or gift cards/codes purchased
 * @codingStandardsIgnoreEnd
 */
trait MerchantRisk
{
    /**
     * Indicator code that most accurately describes the shipping method for the cardholder specific transaction
     *
     * @var string $threeds_v2_merchant_risk_shipping_indicator
     */
    protected $threeds_v2_merchant_risk_shipping_indicator;

    /**
     * Indicates the merchandise delivery timeframe
     *
     * @var string $threeds_v2_merchant_risk_delivery_timeframe
     */
    protected $threeds_v2_merchant_risk_delivery_timeframe;

    /**
     * Indicates whether the cardholder is reordering previously purchased merchandise
     *
     * @var string $threeds_v2_merchant_risk_reorder_items_indicator
     */
    protected $threeds_v2_merchant_risk_reorder_items_indicator;

    /**
     * Indicates whether cardholder is placing an order for merchandise with a future-availability or release date
     *
     * @var string $threeds_v2_merchant_risk_pre_order_purchase_indicator
     */
    protected $threeds_v2_merchant_risk_pre_order_purchase_indicator;

    /**
     * For a pre-ordered purchase, the expected date that the merchandise will be available
     *
     * @var \DateTime $threeds_v2_merchant_risk_pre_order_date
     */
    protected $threeds_v2_merchant_risk_pre_order_date;

    /**
     * Prepaid or gift card purchase
     *
     * @var bool $threeds_v2_merchant_risk_gift_card
     */
    protected $threeds_v2_merchant_risk_gift_card;

    /**
     * For prepaid or gift card purchase, total count of individual prepaid or gift cards/codes purchased
     *
     * @var int $threeds_v2_merchant_risk_gift_card_count
     */
    protected $threeds_v2_merchant_risk_gift_card_count;

    /**
     * Get the expected date that the merchandise will be available
     *
     * @return string|null
     */
    public function getThreedsV2MerchantRiskPreOrderDate()
    {
        return empty($this->threeds_v2_merchant_risk_pre_order_date) ? null :
            $this->threeds_v2_merchant_risk_pre_order_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * Set the expected date that the merchandise will be available
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setThreedsV2MerchantRiskPreOrderDate($value)
    {
        if (is_null($value)) {
            $this->threeds_v2_merchant_risk_pre_order_date = null;

            return $this;
        }

        return $this->parseDate(
            'threeds_v2_merchant_risk_pre_order_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid pre_order_date.'
        );
    }

    /**
     * Prepaid or gift card purchase
     *
     * @param string|bool $value
     * @return $this
     */
    public function setThreedsV2MerchantRiskGiftCard($value)
    {
        $this->threeds_v2_merchant_risk_gift_card = Common::toBoolean($value);

        return $this;
    }

    /**
     * For prepaid or gift card purchase, total count of individual prepaid or gift cards/codes purchased
     *
     * @param int $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2MerchantRiskGiftCardCount($value)
    {
        $this->threeds_v2_merchant_risk_gift_card_count = (int) $value;

        if (
            $this->threeds_v2_merchant_risk_gift_card_count < 0 ||
            $this->threeds_v2_merchant_risk_gift_card_count > 99
        ) {
            throw new InvalidArgument(
                'Invalid argument given for threeds_v2_merchant_risk_gift_card_count. Accepted values between 0 and 99'
            );
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function getMerchantRiskValidations()
    {
        return [
            'threeds_v2_merchant_risk_shipping_indicator' => [
                $this->threeds_v2_merchant_risk_shipping_indicator => [
                    ['threeds_v2_merchant_risk_shipping_indicator' => ShippingIndicators::getAll()]
                ]
            ],
            'threeds_v2_merchant_risk_delivery_timeframe' => [
                $this->threeds_v2_merchant_risk_delivery_timeframe => [
                    ['threeds_v2_merchant_risk_delivery_timeframe' => DeliveryTimeframes::getAll()]
                ]
            ],
            'threeds_v2_merchant_risk_reorder_items_indicator' => [
                $this->threeds_v2_merchant_risk_reorder_items_indicator => [
                    ['threeds_v2_merchant_risk_reorder_items_indicator' => ReorderItemIndicators::getAll()]
                ]
            ],
            'threeds_v2_merchant_risk_pre_order_purchase_indicator' => [
                $this->threeds_v2_merchant_risk_pre_order_purchase_indicator => [
                    ['threeds_v2_merchant_risk_pre_order_purchase_indicator' => PreOrderPurchaseIndicators::getAll()]
                ]
            ]
        ];
    }

    /**
     * Get the Merchant Risk Attributes
     *
     * @return array
     */
    protected function getMerchantRiskAttributes()
    {
        return [
            'shipping_indicator'           => $this->getThreedsV2MerchantRiskShippingIndicator(),
            'delivery_timeframe'           => $this->getThreedsV2MerchantRiskDeliveryTimeframe(),
            'reorder_items_indicator'      => $this->getThreedsV2MerchantRiskReorderItemsIndicator(),
            'pre_order_purchase_indicator' => $this->getThreedsV2MerchantRiskPreOrderPurchaseIndicator(),
            'pre_order_date'               => $this->getThreedsV2MerchantRiskPreOrderDate(),
            'gift_card'                    => $this->getThreedsV2MerchantRiskGiftCard(),
            'gift_card_count'              => $this->getThreedsV2MerchantRiskGiftCardCount()
        ];
    }
}

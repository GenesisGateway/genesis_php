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

namespace Genesis\API\Constants\Transaction;

use Genesis\API\Request\Financial\Alternatives\Klarna\Authorize;

/**
 * Class CustomRequiredParameters
 * @package Genesis\API\Constants\Transaction
 */
class CustomRequiredParameters
{
    /**
     * @return array
     */
    public static function forPpro()
    {
        return [
            'payment_method' => \Genesis\API\Constants\Payment\Methods::getMethods()
        ];
    }

    /**
     * @return array
     */
    public static function forPayByVoucherSale()
    {
        return [
            'card_type'   =>
                \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\CardTypes::getCardTypes(),
            'redeem_type' =>
                \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\RedeemTypes::getRedeemTypes()
        ];
    }

    /**
     * @return array
     * @deprecated PayByVoucherYeepay payment method is deprecated and will be removed
     */
    public static function forPayByVoucherYeepay()
    {
        return array_merge(
            static::forPayByVoucherSale(),
            [
                'product_name'     => null,
                'product_category' => null
            ]
        );
    }

    /**
     * @return array
     */
    public static function forCitadelPayIn()
    {
        return [
            'merchant_customer_id' => null
        ];
    }

    /**
     * @return array
     */
    public static function forInstaDebitPayIn()
    {
        return [
            'customer_account_id' => null
        ];
    }

    /**
     * @return array
     */
    public static function forIDebitPayIn()
    {
        return [
            'customer_account_id' => null
        ];
    }

    /**
     * @return array
     */
    public static function forKlarnaAuthorize()
    {
        return [
            'billing_country' => Authorize::getAllowedCountries()
        ];
    }
}

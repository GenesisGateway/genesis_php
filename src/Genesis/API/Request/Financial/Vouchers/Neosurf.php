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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Financial\Vouchers;

use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Validators\Request\RegexValidator;

/**
 * Class Neosurf
 *
 * Neosurf is a prepaid card (voucher) that is used for online shopping. The card is available in over 100,000 stores
 * worldwide, where customers can buy the prepaid vouchers, denominated up to EUR 250.00 or its equivalent
 * in other currencies.
 *
 * @package Genesis\API\Request\Financial\Vouchers
 *
 * @method string getVoucherNumber()
 * @method Neosurf setVoucherNumber(string $voucherNumber)
 */
class Neosurf extends \Genesis\API\Request\Base\Financial
{
    use AsyncAttributes, PaymentAttributes, AddressInfoAttributes;

    protected $voucher_number;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::NEOSURF;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'remote_ip',
            'amount',
            'currency',
            'voucher_number',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => [
                'AT', 'AU', 'BE', 'BF', 'BI', 'BJ', 'CA', 'CD', 'CF', 'CG', 'CH', 'CI', 'CM', 'CO',
                'CV', 'CY', 'DE', 'DK', 'DZ', 'ES', 'FR', 'GA', 'GB', 'GH', 'GM', 'GN', 'GQ', 'GW',
                'HK', 'IE', 'IT', 'KE', 'LU', 'MA', 'ML', 'MR', 'MW', 'MZ', 'NE', 'NG', 'NL', 'NO',
                'NZ', 'PL', 'PT', 'RO', 'RS', 'RU', 'RW', 'SE', 'SL', 'SN', 'ST', 'TD', 'TG', 'TN', 'TR',
                'TZ', 'UG', 'ZM', 'ZW'
            ],
            'voucher_number'  => new RegexValidator(RegexValidator::PATTERN_NEOSURF_VOUCHER_NUMBER),
            'currency'        => [
                'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'IDR', 'ILS',
                'INR', 'JPY', 'KRW', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TRY',
                'USD', 'XOF', 'ZAR'
            ]
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'voucher_number'     => $this->voucher_number,
            'customer_email'     => $this->customer_email,
            'customer_phone'     => $this->customer_phone,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure()
        ];
    }
}

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

namespace Genesis\API\Request\Financial\OnlineBankingPayments\Citadel;

use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;

/**
 * Class Payout
 *
 * Citadel Payout - oBeP-style alternative payment method
 *
 * @package Genesis\API\Request\Financial\OnlineBankingPayments\Citadel
 *
 * @method Payout setHolderName($value) Set Customer’s bank account holder name
 * @method Payout setIban($value) Set Customer’s IBAN number
 * @method Payout setSwiftCode($value) Set SWIFT/BIC code of the customer’s bank
 * @method Payout setAccountNumber($value) Set National bank account number of the customer
 * @method Payout setBankName($value) Set Customer’s bank name
 * @method Payout setBankCity($value) Set Customer’s bank city
 * @method Payout setBankCode($value) Set Customer’s bank code
 * @method Payout setBranchCode($value) Set Customer’s bank branch code
 * @method Payout setBranchCheckDigit($value) Set Customer’s bank check digit
 */
class Payout extends \Genesis\API\Request\Base\Financial
{
    use PaymentAttributes, AddressInfoAttributes;

    /**
     * Customer’s bank account holder name
     *
     * @var string
     */
    protected $holder_name;

    /**
     * Customer’s IBAN number, check:
     *
     * "Citadel Payment Method Requirements - Supported countries for Payouts"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $iban;

    /**
     * SWIFT/BIC code of the customer’s bank, check:
     *
     * "Citadel Payment Method Requirements - Supported countries for Payouts"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $swift_code;

    /**
     * National bank account number of the customer, check:
     *
     * "Citadel Payment Method Requirements - Supported countries for Payouts"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $account_number;

    /**
     * Customer’s bank name, check:
     *
     * "Citadel Payment Method Requirements - Supported countries for Payouts"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $bank_name;

    /**
     * Customer’s bank city
     *
     * @var string
     */
    protected $bank_city;

    /**
     * Customer’s bank code, check:
     *
     * "Citadel Payment Method Requirements - Supported countries for Payouts"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $bank_code;

    /**
     * Customer’s bank branch code, check:
     *
     * "Citadel Payment Method Requirements - Supported countries for Payouts"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $branch_code;

    /**
     * Customer’s bank check digit
     *
     * @var string
     */
    protected $branch_check_digit;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::CITADEL_PAYOUT;
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
            'amount',
            'currency',
            'customer_email',
            'holder_name',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => [
                'АЕ', 'AT', 'AU', 'BE', 'BG', 'CA', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES',
                'FI', 'FR', 'GB', 'GF', 'GP', 'GR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV',
                'MC', 'MQ', 'MT', 'MX', 'NL', 'PL', 'PT', 'RE', 'SE', 'SI', 'SK'
            ],
            'currency'        => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);

        $this->setRequiredFieldsConditional();
    }

    /**
     * Set the required fields conditional
     *
     * @return void
     */
    protected function setRequiredFieldsConditional()
    {
        $requiredParamsIbanSwiftCode = ['iban', 'swift_code'];

        $requiredFieldsConditional = [
            'billing_country' => [
                'AE' => $requiredParamsIbanSwiftCode,
                'AT' => $requiredParamsIbanSwiftCode,
                'AU' => ['account_number', 'branch_code'],
                'BE' => $requiredParamsIbanSwiftCode,
                'BG' => ['iban'],
                'CA' => ['account_number', 'branch_code', 'bank_code', 'bank_name'],
                'CY' => $requiredParamsIbanSwiftCode,
                'CZ' => ['iban'],
                'DE' => $requiredParamsIbanSwiftCode,
                'DK' => ['account_number', 'bank_code'],
                'EE' => $requiredParamsIbanSwiftCode,
                'ES' => $requiredParamsIbanSwiftCode,
                'FI' => $requiredParamsIbanSwiftCode,
                'FR' => $requiredParamsIbanSwiftCode,
                'GB' => ['account_number', 'bank_code'],
                'GF' => $requiredParamsIbanSwiftCode,
                'GP' => $requiredParamsIbanSwiftCode,
                'GR' => $requiredParamsIbanSwiftCode,
                'HU' => ['account_number'],
                'IE' => $requiredParamsIbanSwiftCode,
                'IT' => $requiredParamsIbanSwiftCode,
                'LT' => $requiredParamsIbanSwiftCode,
                'LU' => $requiredParamsIbanSwiftCode,
                'LV' => $requiredParamsIbanSwiftCode,
                'MC' => $requiredParamsIbanSwiftCode,
                'MQ' => $requiredParamsIbanSwiftCode,
                'MT' => $requiredParamsIbanSwiftCode,
                'MX' => ['iban', 'bank_name'],
                'NL' => $requiredParamsIbanSwiftCode,
                'PL' => ['iban'],
                'PT' => $requiredParamsIbanSwiftCode,
                'RE' => $requiredParamsIbanSwiftCode,
                'SE' => ['iban'],
                'SI' => $requiredParamsIbanSwiftCode,
                'SK' => $requiredParamsIbanSwiftCode
            ]
        ];

        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'customer_email'     => $this->customer_email,
            'customer_phone'     => $this->customer_phone,
            'holder_name'        => $this->holder_name,
            'iban'               => $this->iban,
            'swift_code'         => $this->swift_code,
            'account_number'     => $this->account_number,
            'bank_name'          => $this->bank_name,
            'bank_city'          => $this->bank_city,
            'bank_code'          => $this->bank_code,
            'branch_code'        => $this->branch_code,
            'branch_check_digit' => $this->branch_check_digit,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure()
        ];
    }
}

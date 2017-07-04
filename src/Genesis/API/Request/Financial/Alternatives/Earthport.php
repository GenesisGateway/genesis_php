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

namespace Genesis\API\Request\Financial\Alternatives;

use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;

/**
 * Class Earthport
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives
 *
 * @method Earthport setAccountName($value)
 * @method Earthport setBankName($value)
 * @method Earthport setIban($value)
 * @method Earthport setBic($value)
 * @method Earthport setAccountNumber($value)
 * @method Earthport setBankCode($value)
 * @method Earthport setBranchCode($value)
 * @method Earthport setAccountNumberSuffix($value)
 * @method Earthport setSortCode($value)
 * @method Earthport setAbaRoutingNumber($value)
 */
class Earthport extends \Genesis\API\Request\Base\Financial
{
    use PaymentAttributes, AddressInfoAttributes;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $account_name;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $bank_name;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $iban;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $bic;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $account_number;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $bank_code;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $branch_code;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $account_number_suffix;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $sort_code;

    /**
     * Conditional field based on country.
     * Check "Earthport Payment Method Requirements"
     * in the official API documentation
     *
     * @var string
     */
    protected $aba_routing_number;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::EARTHPORT;
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
            'account_name',
            'bank_name',
            'billing_first_name',
            'billing_last_name',
            'billing_address1',
            'billing_city',
            'billing_country',
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => [
                'AD', 'AU', 'AT', 'BH', 'BS', 'BE', 'BG', 'CA', 'CY', 'CZ', 'DK', 'EG', 'EE',
                'FI', 'FR', 'DE', 'GR', 'HK', 'HU', 'ID', 'IE', 'IL', 'IT', 'JP', 'KE', 'LV',
                'LI', 'LT', 'LU', 'MY', 'MT', 'MA', 'NL', 'NZ', 'NO', 'PK', 'PH', 'PL', 'PT',
                'RO', 'SG', 'SK', 'SI', 'ES', 'SE', 'CH', 'GB', 'US', 'VN'
            ],
            'currency'        => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);

        $this->setRequiredFieldValuesConditional();
    }

    /**
     * Set the required fields - conditionally depending on other fields
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function setRequiredFieldValuesConditional()
    {
        $commonIbanFields = [
            'iban',
            'bic'
        ];
        $commonAccountFields = [
            'account_number',
            'bank_code',
            'branch_code'
        ];

        $requiredFieldsConditional = [
            'billing_country' => [
                'AD'   => $commonIbanFields,
                'AU'   => $commonAccountFields,
                'AT'   => $commonIbanFields,
                'BH'   => $commonIbanFields,
                'BS'   => $commonIbanFields,
                'BE'   => $commonIbanFields,
                'BG'   => $commonIbanFields,
                'CA'   => $commonAccountFields,
                'CY'   => $commonIbanFields,
                'CZ'   => $commonIbanFields,
                'DK'   => $commonIbanFields,
                'EG'   => [
                    'account_number',
                    'bic'
                ],
                'EE'   => $commonIbanFields,
                'FI'   => $commonIbanFields,
                'FR'   => $commonIbanFields,
                'DE'   => $commonIbanFields,
                'GR'   => $commonIbanFields,
                'HK'   => [
                    'bank_code',
                    'branch_code',
                    'account_number',
                    'account_number_suffix'
                ],
                'HU'   => $commonIbanFields,
                'ID'   => $commonAccountFields,
                'IE'   => $commonIbanFields,
                'IL'   => $commonIbanFields,
                'IT'   => $commonIbanFields,
                'JP'   => $commonIbanFields,
                'KE'   => $commonIbanFields,
                'LV'   => $commonIbanFields,
                'LI'   => $commonIbanFields,
                'LT'   => $commonIbanFields,
                'LU'   => $commonIbanFields,
                'MY'   => [
                    'account_number',
                    'bic'
                ],
                'MT'   => $commonIbanFields,
                'MA'   => [
                    'account_number'
                ],
                'NL'   => $commonIbanFields,
                'NZ'   => [
                    'bank_code',
                    'branch_code',
                    'account_number',
                    'account_number_suffix'
                ],
                'NO'   => $commonIbanFields,
                'PK'   => $commonIbanFields,
                'PH'   => [
                    'bank_code',
                    'account_number'
                ],
                'PL'   => $commonIbanFields,
                'PT'   => $commonIbanFields,
                'RO'   => $commonIbanFields,
                'SG'   => $commonAccountFields,
                'SK'   => $commonIbanFields,
                'SI'   => $commonIbanFields,
                'ES'   => $commonIbanFields,
                'SE'   => [
                    'bank_code',
                    'account_number',
                    'bic'
                ],
                'CH'   => $commonIbanFields,
                'GB'   => [
                    'account_number',
                    'sort_code'
                ],
                'US'   => [
                    'billing_state',
                    'account_number',
                    'aba_routing_number'
                ],
                'VN'   => [
                    'account_number',
                    'bic'
                ]
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
            'amount'                => $this->transformAmount($this->amount, $this->currency),
            'currency'              => $this->currency,
            'customer_email'        => $this->customer_email,
            'customer_phone'        => $this->customer_phone,
            'account_name'          => $this->account_name,
            'bank_name'             => $this->bank_name,
            'iban'                  => $this->iban,
            'bic'                   => $this->bic,
            'account_number'        => $this->account_number,
            'bank_code'             => $this->bank_code,
            'branch_code'           => $this->branch_code,
            'account_number_suffix' => $this->account_number_suffix,
            'sort_code'             => $this->sort_code,
            'aba_routing_number'    => $this->aba_routing_number,
            'billing_address'       => $this->getBillingAddressParamsStructure(),
        ];
    }
}

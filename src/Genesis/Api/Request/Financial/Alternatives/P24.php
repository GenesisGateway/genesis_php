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

namespace Genesis\Api\Request\Financial\Alternatives;

use Genesis\Api\Constants\Transaction\Parameters\Alternatives\P24\BankCodes;
use Genesis\Utils\Common;

/**
 * Class P24
 *
 * Alternative payment method
 *
 * @package Genesis\Api\Request\Financial\Alternatives
 *
 * @method integer getBankCode()       The Bank Code
 * @method $this   setBankCode($value) The Bank Code
 */
class P24 extends \Genesis\Api\Request\Base\Financial\Alternative
{
    /**
     * Bank codes may vary depending on the gateway configuration
     *
     * @var integer $bank_code
     */
    protected $bank_code;

    private $bankCodeCurrencies = ['EUR', 'PLN'];

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::P24;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        parent::setRequiredFields();

        $requiredFieldValues = [
            'billing_country' => [
                'AD', 'AT', 'BE', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'EL', 'ES', 'NL',
                'IE', 'IS', 'LT', 'LV', 'LU', 'MT', 'DE', 'NO', 'PL', 'PT', 'SM', 'SK',
                'SI', 'CH', 'SE', 'HU', 'GB', 'IT', 'US', 'CA', 'JP', 'UA', 'BY', 'RU'
            ],
            'currency'        => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    protected function checkRequirements()
    {
        $requiredFieldValuesConditional = [
            'bank_code' => [
                $this->bank_code => [
                    [
                        'bank_code' => BankCodes::getAll(),
                        'currency' => $this->bankCodeCurrencies
                    ]
                ]
            ]
        ];

        if (in_array($this->currency, $this->bankCodeCurrencies)) {
            $this->requiredFieldValuesConditional = Common::createArrayObject($requiredFieldValuesConditional);
        }

        parent::checkRequirements();
    }


    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            parent::getPaymentTransactionStructure(),
            array(
                'bank_code' => $this->bank_code
            )
        );
    }
}

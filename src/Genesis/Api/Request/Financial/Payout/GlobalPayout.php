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

namespace Genesis\Api\Request\Financial\Payout;

use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\CustomerAddress\BillingInfoAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class GlobalPayout
 *
 * Global Payout is a transaction type based on Open Banking APIs, used for initiating bank payments
 *
 * @package Genesis\Api\Request\Financial\Payout
 *
 * @method $this  setPayeeAccountId($value);
 * @method string getPayeeAccountId()
 */
class GlobalPayout extends Financial
{
    use BillingInfoAttributes;
    use PaymentAttributes;

    /**
     * Unique Account ID of the Payee
     *
     * @var string
     */
    protected $payee_account_id;

    /**
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::GLOBAL_PAYOUT;
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
            'payee_account_id'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'amount'           => $this->transformAmount($this->amount, $this->currency),
            'currency'         => $this->currency,
            'payee_account_id' => $this->payee_account_id,
            'billing_address'  => $this->getBillingAddressParamsStructure()
        ];
    }
}

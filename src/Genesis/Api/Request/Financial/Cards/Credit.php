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

namespace Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Traits\Request\Financial\AccountOwnerAttributes;
use Genesis\Api\Traits\Request\Financial\CustomerIdentificationData;
use Genesis\Api\Traits\Request\Financial\PurposeOfPaymentAttributes;
use Genesis\Api\Traits\Request\Financial\SourceOfFundsAttributes;

/**
 * Class Credit
 *
 * Credit Request
 *
 * @package Genesis\Api\Request\Financial\Cards
 */
class Credit extends \Genesis\Api\Request\Base\Financial\Reference
{
    use AccountOwnerAttributes;
    use CustomerIdentificationData;
    use PurposeOfPaymentAttributes;
    use SourceOfFundsAttributes;

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'reference_id',
            'amount'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Apply transformation: Convert to Minor currency unit
     * When there is no currency the amount will not be modified
     *
     * @param string $amount
     * @param string $currency
     *
     * @return string
     */
    protected function transformAmount($amount = '', $currency = '')
    {
        if (empty($currency)) {
            return $amount;
        }

        return parent::transformAmount($amount, $currency);
    }

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::CREDIT;
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            $this->getSourceOfFundsStructure(),
            [
                'reference_id'            => $this->reference_id,
                'amount'                  => $this->transformAmount($this->amount, $this->currency),
                'customer_identification' => $this->getCustomerIdentificationDataStructure(),
                'account_owner'           => $this->getAccountOwnerAttributesStructure(),
                'purpose_of_payment'      => $this->purpose_of_payment
            ]
        );
    }
}

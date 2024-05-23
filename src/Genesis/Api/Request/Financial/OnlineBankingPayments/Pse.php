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

namespace Genesis\Api\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Traits\Request\Financial\PendingPaymentAttributes;

/**
 * Class Pse
 *
 * PSE (Pagos Seguros en Linea) is the preferred alternative payment solution in Colombia.The solution consists
 * of an interface that offers the client the option to pay for their online purchases in cash,
 * directing it to their online banking.
 *
 * @package Genesis\Api\Request\Financial\OnlineBankingPayments
 */
class Pse extends \Genesis\Api\Request\Base\Financial\SouthAmericanPayment
{
    use PendingPaymentAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::PSE;
    }

    /**
     * @return array
     */
    public function getAllowedBillingCountries()
    {
        return ['CO'];
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            parent::getPaymentTransactionStructure(),
            ['return_pending_url' => $this->getReturnPendingUrl()]
        );
    }
}

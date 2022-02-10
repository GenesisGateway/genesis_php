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

namespace Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\Base\Financial\SouthAmericanPayment;
use Genesis\API\Traits\Request\Financial\PendingPaymentAttributes;

/**
 * Class Davivienda
 *
 * Davivienda is offering the Bill pay service which is a fast, easy and secure way to pay and
 * manage your bills online to anyone, anytime in Colombia.
 *
 * @package Genesis\API\Request\Financial\OnlineBankingPayments
 */
class Davivienda extends SouthAmericanPayment
{
    use PendingPaymentAttributes;

    /**
     * Return transaction types
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::DAVIVIENDA;
    }

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

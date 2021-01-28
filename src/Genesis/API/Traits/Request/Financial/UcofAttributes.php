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

namespace Genesis\API\Traits\Request\Financial;

/**
 * The UCOF transaction uses a previously stored credential for a fixed or variable amount and it does not occur
 * on a scheduled or regularly occurring transaction date. With it, the cardholder has provided consent to the merchant
 * to initiate one or more future transactions. An example of such a transaction is an account auto-top up.
 *
 * Trait UcofAttributes
 * @package Genesis\API\Traits\Request\Financial
 *
 * @method string getCredentialOnFileTransactionIdentifier()       Ucof attribute
 * @method $this  setCredentialOnFileTransactionIdentifier($value) Ucof attribute
 * @method string getCredentialOnFileSettlementDate()              Ucof attribute
 * @method $this  setCredentialOnFileSettlementDate($value)        Ucof attribute
 */
trait UcofAttributes
{
    /**
     * Ucof attribute specific only for Authorize and Sale transactions
     *
     * @var string $credential_on_file_transaction_identifier
     */
    protected $credential_on_file_transaction_identifier;

    /**
     * Ucof attribute specific only for Authorize and Sale transactions
     *
     * @var string $credential_on_file_settlement_date
     */
    protected $credential_on_file_settlement_date;

    /**
     * Returns the Ucof Attributes Structure
     *
     * @return array
     */
    protected function getUcofAttributesStructure()
    {
        return [
            'credential_on_file_transaction_identifier' => $this->credential_on_file_transaction_identifier,
            'credential_on_file_settlement_date'        => $this->credential_on_file_settlement_date
        ];
    }
}

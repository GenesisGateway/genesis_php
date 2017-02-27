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

/**
 * Class PPRO
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives
 *
 * @method PPRO setPaymentType($value) Set used payment type
 * @method PPRO setAccountNumber($value) Set valid account number
 * @method PPRO setBankCode($value) Set a valid bank code
 * @method PPRO setBic($value) Set a valid BIC
 * @method PPRO setIban($value) Set a valid IBAN bank account
 * @method PPRO setAccountPhone($value) Set phone number for destination account to pay out
 */
class PPRO extends \Genesis\API\Request\Base\Financial\Alternatives\Asynchronous\AbstractTransaction
{
    /**
     * Used payment method
     *
     * @var string
     */
    protected $payment_type;

    /**
     * Must contain valid account number, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $account_number;

    /**
     * Must contain valid bank code, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $bank_code;

    /**
     * Must contain valid BIC, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $bic;

    /**
     * Must contain valid IBAN, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $iban;

    /**
     * Must contain valid phone number for destination account to pay out, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $account_phone;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::PPRO;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = array(
            'transaction_id',
            'payment_type',
            'remote_ip',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'customer_email',
            'billing_country'
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getRequestTreeStructure()
    {
        $treeStructure = parent::getRequestTreeStructure();

        return array_merge(
            $treeStructure,
            array(
                'payment_type'       => $this->payment_type,
                'account_number'     => $this->account_number,
                'bank_code'          => $this->bank_code,
                'bic'                => $this->bic,
                'iban'               => $this->iban,
                'account_phone'      => $this->account_phone
            )
        );
    }
}

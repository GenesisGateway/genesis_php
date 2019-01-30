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

use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Financial\BankAttributes;
use Genesis\Exceptions\ErrorParameter;

/**
 * Class InstantTransfer
 *
 * InstantTransfer - oBeP-style alternative payment method
 *
 * @package Genesis\API\Request\Financial\OnlineBankingPayments
 *
 */
class InstantTransfer extends \Genesis\API\Request\Base\Financial
{
    use AsyncAttributes, PaymentAttributes, AddressInfoAttributes, BankAttributes;

    /**
     * IBAN Regex Validation Pattern
     */
    const PATTERN_DE_IBAN = '/^DE\d{20}$/';

    /**
     * @param $value
     *
     * @return InstantTransfer
     * @throws ErrorParameter
     */
    public function setBillingCountry($value)
    {
        switch ($value) {
            case 'DE':
                if (empty($this->iban) === false) {
                    $this->setIban($this->iban);
                }
                break;
        }

        return parent::setBillingCountry($value);
    }

    /**
     * @param $value
     *
     * @return InstantTransfer
     * @throws ErrorParameter
     */
    public function setIban($value)
    {
        if ($this->billing_country === 'DE') {
            $this->validateIban(self::PATTERN_DE_IBAN, $value);
        }

        return parent::setIban($value);
    }

    /**
     * @param string $pattern Regex pattern for IBAN validation
     * @param string $value
     *
     * @throws ErrorParameter
     */
    protected function validateIban($pattern, $value)
    {
        if (!preg_match($pattern, $value)) {
            throw new ErrorParameter('Invalid IBAN. Please check the documenatition for more information.');
        }
    }

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::INSTANT_TRANSFER;
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
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => [ 'DE' ]
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
            'usage'              => $this->usage,
            'remote_ip'          => $this->remote_ip,
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'customer_email'     => $this->customer_email,
            'iban'               => $this->iban,
            'bic'                => $this->bic,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure()
        ];
    }
}

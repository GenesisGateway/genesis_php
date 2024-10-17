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

namespace Genesis\Api\Request\Financial\Alternatives\Invoice;

use Genesis\Api\Constants\Financial\Alternative\Invoice\PaymentTypes;
use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial\Alternative\Invoice;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Items;
use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\Alternatives\Invoice\InvoiceValidation;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Api\Traits\Request\Financial\ReferenceAttributes;
use Genesis\Api\Traits\Validations\Request\Validations;
use Genesis\Api\Validators\Request\RegexValidator;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidClassMethod;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Capture
 *
 * Alternative payment method
 *
 * @package Genesis\Api\Request\Financial\Alternatives\Invoice
 *
 * @method $this  setAccountHolder(string $value)              Set the account holder
 * @method $this  setBankTransferRemittanceSlip(string $value) Set the bank transfer remittance slip
 * @method string getAccountHolder()                           Get the account holder
 * @method string getIban()                                    Get the IBAN
 * @method string getBankTransferRemittanceSlip()              Get the bank transfer remittance slip
 */
class Capture extends Invoice
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use PaymentAttributes;
    use ReferenceAttributes;
    use MagicAccessors;
    use Validations;
    use InvoiceValidation;

    /**
     * Account Holder, required for Secure Invoice in case of Direct Debit payment
     * (payment_method_category: pay_over_time)
     *
     * @var string
     */
    protected $account_holder;

    /**
     * IBAN, required for Secure Invoice in case of Direct Debit payment (payment_method_category: pay_over_time)
     *
     * @var string
     */
    protected $iban;

    /**
     * Bank Transfer Remittance Slip, required for Secure Invoice. Less than 16 symbols.
     *
     * @var string
     */
    protected $bank_transfer_remittance_slip;

    /**
     * Capture constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = new Items();
    }

    /**
     * IBAN setter
     *
     * @param $value string
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setIban($value)
    {
        if (!preg_match(RegexValidator::PATTERN_IBAN, $value)) {
            throw new InvalidArgument(
                'Invalid IBAN format. Please provide a valid IBAN.'
            );
        }
        $this->iban = $value;

        return $this;
    }

    /**
     * Returns the Request transaction type
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::INVOICE_CAPTURE;
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
            'payment_type',
            'reference_id',
            'amount',
            'currency'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'payment_type' => PaymentTypes::getAll(),
            'currency'     => ['EUR', 'DKK', 'NOK', 'SEK'],
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Perform field validation
     *
     * @return void
     *
     * @throws ErrorParameter
     * @throws InvalidArgument
     * @throws InvalidClassMethod
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateItems();
        $this->validateAmount();
    }

    /**
     * Return additional request attributes
     *
     * @return array
     *
     * @throws InvalidArgument
     */
    protected function getPaymentTransactionStructure()
    {
        $this->items->setCurrency($this->currency);

        return array_merge(
            parent::getPaymentTransactionStructure(),
            [
                'payment_type'                  => $this->payment_type,
                'reference_id'                  => $this->reference_id,
                'account_holder'                => $this->account_holder,
                'iban'                          => $this->iban,
                'bank_transfer_remittance_slip' => $this->bank_transfer_remittance_slip,
            ]
        );
    }
}

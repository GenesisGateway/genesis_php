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

namespace Genesis\API\Request\Financial\Alternatives\TransferTo;

use Genesis\API\Constants\Transaction\Parameters\IdentificationTypes;
use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\Base\Financial;
use Genesis\API\Traits\Request\CustomerAddress\BillingInfoAttributes;
use Genesis\API\Traits\Request\CustomerAddress\ShippingInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * APM TransferTo Payout
 *
 * Provides payment services:
 *  BanAccount
 *  MobileWallet
 *  CashPickup
 *
 * Class Payout
 * @package Genesis\API\Request\Financial\Alternatives\TransferTo
 *
 * @method setPayerId($value) ID of the Payer used to deliver the money through one of the 3 services
 * @method setBankAccountNumber($value) Bank identification number of the customer
 * @method setIfsCode($value) Bank code of the bank in which the consumer resides
 * @method setMsisdn($value) Number uniquely identifying a subscription in a Global System
 * @method setBranchNumber($value) Branch number
 * @method setAccountType($value) Account type
 * @method setRegisteredName($value) Registered name of the business
 * @method setRegistrationNumber($value) Registration number
 * @method setIban($value) Bank account number in IBAN format
 * @method setIdNumber($value) Identification number
 */
class Payout extends Financial
{
    use RestrictedSetter, AsyncAttributes, PaymentAttributes, BillingInfoAttributes, ShippingInfoAttributes;

    /**
     * Must contain valid e-mail of customer
     *
     * @var string $customer_email
     */
    protected $customer_email;

    /**
     * ID of the Payer used to deliver the money through one of the 3 services
     *
     * @var string $payer_id
     */
    protected $payer_id;

    /**
     * Bank identification number of the customer. *Requirement based on the Payer
     *
     * @var string $bank_account_number
     */
    protected $bank_account_number;

    /**
     * Bank code of the bank in which the consumer resides. *Requirement based on the Payer
     *
     * @var string $ifs_code
     */
    protected $ifs_code;

    /**
     * Number uniquely identifying a subscription in a Global System. *Requirement based on the Payer
     *
     * @var string $msisdn
     */
    protected $msisdn;

    /**
     * Branch number. *Requirement based on the Payer
     *
     * @var string $branch_number
     */
    protected $branch_number;

    /**
     * Account type. *Requirement based on the Payer
     *
     * @var string $account_type
     */
    protected $account_type;

    /**
     * Registered name of the business. *Requirement based on the Payer
     *
     * @var string $registered_name
     */
    protected $registered_name;

    /**
     * Registration number. *Requirement based on the Payer
     *
     * @var string $registration_number
     */
    protected $registration_number;

    /**
     * Bank account number in IBAN format. *Requirement based on the Payer
     *
     * @var string $iban
     */
    protected $iban;

    /**
     * Identification type
     *
     * @var string $id_type
     */
    protected $id_type;

    /**
     * Identification number. *Requirement based on the Payer
     *
     * @var string $id_number
     */
    protected $id_number;

    protected function getTransactionType()
    {
        return Types::TRANSFER_TO_PAYOUT;
    }

    /**
     * Must contain valid e-mail of customer
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerEmail($value)
    {
        $customerEmail = trim($value);

        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgument(
                'Please, enter a valid Customer Email'
            );
        }

        $this->customer_email = $customerEmail;

        return $this;
    }

    /**
     * Identification type
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setIdType($value)
    {
        if ($value === null) {
            $this->id_type = null;

            return $this;
        }

        $this->allowedOptionsSetter(
            'id_type',
            IdentificationTypes::getAll(),
            $value,
            'Invalid value for id_type.'
        );

        return $this;
    }

    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'payer_id'
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldsValues = [
            'currency' => ['EUR', 'GBP', 'HKD', 'USD']
        ];

        $this->requiredFieldValues = Common::createArrayObject($requiredFieldsValues);
    }

    protected function getPaymentTransactionStructure()
    {
        return [
            'return_success_url'  => $this->return_success_url,
            'return_failure_url'  => $this->return_failure_url,
            'amount'              => $this->transformAmount($this->amount, $this->currency),
            'currency'            => $this->currency,
            'customer_email'      => $this->customer_email,
            'payer_id'            => $this->payer_id,
            'bank_account_number' => $this->bank_account_number,
            'ifs_code'            => $this->ifs_code,
            'msisdn'              => $this->msisdn,
            'branch_number'       => $this->branch_number,
            'account_type'        => $this->account_type,
            'registered_name'     => $this->registered_name,
            'registration_number' => $this->registration_number,
            'iban'                => $this->iban,
            'id_type'             => $this->id_type,
            'id_number'           => $this->id_number,
            'billing_address'     => $this->getBillingAddressParamsStructure(),
            'shipping_address'    => $this->getShippingAddressParamsStructure()
        ];
    }
}

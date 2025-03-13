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

namespace Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AccountOwnerAttributes;
use Genesis\Api\Traits\Request\Financial\CredentialOnFileAttributes;
use Genesis\Api\Traits\Request\Financial\CustomerIdentificationData;
use Genesis\Api\Traits\Request\Financial\DescriptorAttributes;
use Genesis\Api\Traits\Request\Financial\FxRateAttributes;
use Genesis\Api\Traits\Request\Financial\PurposeOfPaymentAttributes;
use Genesis\Api\Traits\Request\Financial\SourceOfFundsAttributes;
use Genesis\Api\Traits\Request\Financial\UcofAttributes;
use Genesis\Api\Traits\Request\Payout\MoneyTransferPayoutAttributes;
use Genesis\Exceptions\InvalidMethod;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Payout
 *
 * Payout Request
 *
 * @package Genesis\Api\Request\Financial\Cards
 */
class Payout extends \Genesis\Api\Request\Base\Financial\Cards\CreditCard
{
    use AccountOwnerAttributes;
    use AddressInfoAttributes;
    use CredentialOnFileAttributes;
    use CustomerIdentificationData;
    use DescriptorAttributes;
    use FxRateAttributes;
    use MoneyTransferPayoutAttributes;
    use PurposeOfPaymentAttributes;
    use SourceOfFundsAttributes;
    use UcofAttributes;

    const MONEY_TRANSFER_SENDER_ACCOUNT_NUMBER_MAX_LENGTH = 33;
    const MONEY_TRANSFER_SERVICE_PROVIDER_NAME_MAX_LENGTH = 25;

    /**
     * Payout doesn't support Scheme Tokenized parameter
     *
     * @throws InvalidMethod
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSchemeTokenized($value)
    {
        throw new InvalidMethod(
            sprintf(
                'You\'re trying to call a non-existent method setSchemeTokenized of class %s!',
                static::class
            )
        );
    }

    /**
     * Payout doesn't support Scheme Tokenized parameter
     *
     * @throws InvalidMethod
     */
    public function getSchemeTokenized()
    {
        throw new InvalidMethod(
            sprintf(
                'You\'re trying to call a non-existent method getSchemeTokenized of class %s!',
                static::class
            )
        );
    }

    /**
     * Payout doesn't support CredentialOnFile Settlement Date attribute
     *
     * @return void
     *
     * @throws InvalidMethod
     */
    public function getCredentialOnFileSettlementDate()
    {
        throw new InvalidMethod(
            sprintf(
                'You\'re trying to call a non-existent method %s of class %s!',
                static::class,
                __FUNCTION__
            )
        );
    }

    /**
     * Payout doesn't support CredentialOnFile Settlement Date attribute
     *
     * @param $value
     *
     * @return void
     *
     * @throws InvalidMethod
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setCredentialOnFileSettlementDate($value)
    {
        throw new InvalidMethod(
            sprintf(
                'You\'re trying to call a non-existent method %s of class %s!',
                static::class,
                __FUNCTION__
            )
        );
    }

/**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::PAYOUT;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        parent::setRequiredFields();

        $requiredFieldsConditional = $this->requiredTokenizationFieldsConditional() +
                                     $this->requiredCCFieldsConditional() +
                                     $this->requiredMoneyTransferFieldsConditional();

        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getTransactionAttributes()
    {
        return array_merge(
            [
                'customer_email'            => $this->customer_email,
                'customer_phone'            => $this->customer_phone,
                'document_id'               => $this->document_id,
                'billing_address'           => $this->getBillingAddressParamsStructure(),
                'shipping_address'          => $this->getShippingAddressParamsStructure(),
                'fx_rate_id'                => $this->fx_rate_id,
                'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure(),
                'money_transfer'            => $this->getMoneyTransferPayoutStructure(),
                'customer_identification'   => $this->getCustomerIdentificationDataStructure(),
                'account_owner'             => $this->getAccountOwnerAttributesStructure(),
                'purpose_of_payment'        => $this->purpose_of_payment
            ],
            $this->getSourceOfFundsStructure(),
            $this->getCredentialOnFileAttributesStructure(),
            $this->getUcofAttributesStructure()
        );
    }

    /**
     * Returns Cards\Payout UCOF attributes structure
     *
     * @return array
     */
    protected function getUcofAttributesStructure()
    {
        return [
            'credential_on_file_transaction_identifier' => $this->credential_on_file_transaction_identifier
        ];
    }
}

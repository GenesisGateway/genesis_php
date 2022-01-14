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

namespace Genesis\API\Request\Financial\Mobile;

use Genesis\API\Constants\Transaction\Parameters\Mobile\GooglePay\PaymentTypes;
use Genesis\API\Constants\Transaction\Types as TransactionType;
use Genesis\API\Request\Base\Financial;
use Genesis\API\Traits\Request\DocumentAttributes;
use Genesis\API\Traits\Request\Financial\BirthDateAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Mobile\GooglePayAttributes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency;

/**
 * Class GooglePay
 *
 * Google pay Request
 *
 * @package Genesis\API\Request\Financial\Mobile\GooglePay
 */
class GooglePay extends Financial
{
    use AddressInfoAttributes, PaymentAttributes, GooglePayAttributes, RestrictedSetter,
        BirthDateAttributes, BusinessAttributes, DocumentAttributes;

    /**
     * Returns the Request transaction type
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return TransactionType::GOOGLE_PAY;
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
            'amount',
            'currency',
            'token_signature',
            'token_signed_key',
            'token_signatures',
            'token_protocol_version',
            'token_signed_message',
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'currency'     => Currency::getList(),
            'payment_type' => PaymentTypes::getAllowedPaymentTypes(),
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    public function getPaymentTransactionStructure()
    {
        return [
            'usage'               => $this->usage,
            'amount'              => $this->transformAmount($this->amount, $this->currency),
            'currency'            => $this->currency,
            'remote_ip'           => $this->remote_ip,
            'payment_type'        => $this->payment_type,
            'payment_token'       => $this->getPaymentTokenStructure(),
            'customer_email'      => $this->customer_email,
            'customer_phone'      => $this->customer_phone,
            'birth_date'          => $this->getBirthDate(),
            'billing_address'     => $this->getBillingAddressParamsStructure(),
            'shipping_address'    => $this->getShippingAddressParamsStructure(),
            'business_attributes' => $this->getBusinessAttributesStructure(),
            'document_id'         => $this->document_id,
        ];
    }
}

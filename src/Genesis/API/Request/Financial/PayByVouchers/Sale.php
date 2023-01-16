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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Financial\PayByVouchers;

use Genesis\API\Constants\Transaction\Parameters\PayByVouchers\CardTypes;
use Genesis\API\Constants\Transaction\Parameters\PayByVouchers\RedeemTypes;
use Genesis\API\Traits\Request\Financial\VoucherAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\CreditCardAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;
use Genesis\Utils\Currency;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Sale
 *
 * PayByVoucher purchase via Debit/Credit Sale
 *
 * @package Genesis\API\Request\Financial\PayByVouchers
 */
class Sale extends \Genesis\API\Request\Base\Financial
{
    use VoucherAttributes, PaymentAttributes, CreditCardAttributes, AddressInfoAttributes, DescriptorAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::PAYBYVOUCHER_SALE;
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
            'card_type',
            'redeem_type',
            'amount',
            'currency',
            'card_holder',
            'card_number',
            'expiration_month',
            'expiration_year'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = array_merge(
            [
                'card_type'   => CardTypes::getCardTypes(),
                'redeem_type' => RedeemTypes::getRedeemTypes(),
                'currency'    => Currency::getList()
            ],
            $this->getCCFieldValueFormatValidators()
        );

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'card_type'                 => $this->card_type,
            'redeem_type'               => $this->redeem_type,
            'amount'                    => $this->transformAmount($this->amount, $this->currency),
            'currency'                  => $this->currency,
            'card_holder'               => $this->card_holder,
            'card_number'               => $this->card_number,
            'cvv'                       => $this->cvv,
            'expiration_month'          => $this->expiration_month,
            'expiration_year'           => $this->expiration_year,
            'customer_email'            => $this->customer_email,
            'customer_phone'            => $this->customer_phone,
            'birth_date'                => $this->getBirthDate(),
            'billing_address'           => $this->getBillingAddressParamsStructure(),
            'shipping_address'          => $this->getShippingAddressParamsStructure(),
            'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure()
        ];
    }

    /**
     * Skip Credit Card validation if Client-Side Encryption is set
     *
     * @return void
     */
    protected function checkRequirements()
    {
        $this->removeCreditCardValidations();

        parent::checkRequirements();
    }
}

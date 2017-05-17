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

namespace Genesis\API\Request\Financial\Cards;

use Genesis\API\Traits\Request\Financial\GamingAttributes;
use Genesis\API\Traits\Request\MotoAttributes;
use Genesis\API\Traits\Request\Financial\NotificationAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\CreditCardAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\MpiAttributes;
use Genesis\API\Traits\Request\RiskAttributes;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;

/**
 * Class Sale3D
 *
 * Sale 3D Request
 *
 * @package Genesis\API\Request\Financial\Cards
 */
class Sale3D extends \Genesis\API\Request\Base\Financial
{
    use GamingAttributes, MotoAttributes, NotificationAttributes, AsyncAttributes,
        PaymentAttributes, CreditCardAttributes, AddressInfoAttributes,
        MpiAttributes, RiskAttributes, DescriptorAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::SALE_3D;
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
                'currency' => \Genesis\Utils\Currency::getList()
            ],
            $this->getCCFieldValueFormatValidators()
        );

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);

        $requiredFieldsConditional = [
            'notification_url'   => ['return_success_url', 'return_failure_url'],
            'return_success_url' => ['notification_url', 'return_failure_url'],
            'return_failure_url' => ['notification_url', 'return_success_url']
        ];

        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);

        $requiredFieldsGroups = [
            'synchronous'  => ['notification_url', 'return_success_url', 'return_failure_url'],
            'asynchronous' => ['mpi_eci']
        ];

        $this->requiredFieldsGroups = \Genesis\Utils\Common::createArrayObject($requiredFieldsGroups);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'gaming'                    => $this->gaming,
            'moto'                      => $this->moto,
            'notification_url'          => $this->notification_url,
            'return_success_url'        => $this->return_success_url,
            'return_failure_url'        => $this->return_failure_url,
            'amount'                    => $this->transformAmount($this->amount, $this->currency),
            'currency'                  => $this->currency,
            'card_holder'               => $this->card_holder,
            'card_number'               => $this->card_number,
            'cvv'                       => $this->cvv,
            'expiration_month'          => $this->expiration_month,
            'expiration_year'           => $this->expiration_year,
            'customer_email'            => $this->customer_email,
            'customer_phone'            => $this->customer_phone,
            'birth_date'                => $this->birth_date,
            'billing_address'           => $this->getBillingAddressParamsStructure(),
            'shipping_address'          => $this->getShippingAddressParamsStructure(),
            'mpi_params'                => $this->getMpiParamsStructure(),
            'risk_params'               => $this->getRiskParamsStructure(),
            'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure()
        ];
    }
}

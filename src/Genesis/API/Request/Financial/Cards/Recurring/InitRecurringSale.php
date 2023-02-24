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

namespace Genesis\API\Request\Financial\Cards\Recurring;

use Genesis\API\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\API\Traits\Request\Financial\Cards\Recurring\ManagedRecurringAttributes;
use Genesis\API\Traits\Request\Financial\Cards\Recurring\RecurringCategoryAttributes;
use Genesis\API\Traits\Request\Financial\FxRateAttributes;
use Genesis\API\Traits\Request\MotoAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\RiskAttributes;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;
use Genesis\API\Traits\Request\Financial\TravelData\TravelDataAttributes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class InitRecurringSale
 *
 * InitRecurringSale Request
 *
 * @package Genesis\API\Request\Financial\Cards\Recurring
 */
class InitRecurringSale extends \Genesis\API\Request\Base\Financial\Cards\CreditCard
{
    use MotoAttributes, AddressInfoAttributes, RiskAttributes, DescriptorAttributes,
        TravelDataAttributes, FxRateAttributes, BusinessAttributes, RestrictedSetter,
        ManagedRecurringAttributes, RecurringCategoryAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::INIT_RECURRING_SALE;
    }

    /**
     * Return the required parameters keys which values could evaluate as empty
     * Example value:
     * array(
     *     'class_property' => 'request_structure_key'
     * )
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return array(
            'amount' => static::REQUEST_KEY_AMOUNT
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        parent::setRequiredFields();

        $requiredFieldsConditional = array_merge(
            $this->requiredTokenizationFieldsConditional(),
            $this->requiredManagedRecurringFieldsConditional()
        );

        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getTransactionAttributes()
    {
        return [
            'moto'                      => $this->moto,
            'customer_email'            => $this->customer_email,
            'customer_phone'            => $this->customer_phone,
            'document_id'               => $this->document_id,
            'billing_address'           => $this->getBillingAddressParamsStructure(),
            'shipping_address'          => $this->getShippingAddressParamsStructure(),
            'risk_params'               => $this->getRiskParamsStructure(),
            'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure(),
            'travel'                    => $this->getTravelData(),
            'fx_rate_id'                => $this->fx_rate_id,
            'business_attributes'       => $this->getBusinessAttributesStructure(),
            'managed_recurring'         => $this->getManagedRecurringAttributesStructure(),
            'recurring_category'        => $this->recurring_category
        ];
    }
}

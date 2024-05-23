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

namespace Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AccountOwnerAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\Api\Traits\Request\Financial\Cards\Recurring\ManagedRecurringAttributes;
use Genesis\Api\Traits\Request\Financial\Cards\Recurring\RecurringCategoryAttributes;
use Genesis\Api\Traits\Request\Financial\Cards\Recurring\RecurringTypeAttributes;
use Genesis\Api\Traits\Request\Financial\CryptoAttributes;
use Genesis\Api\Traits\Request\Financial\DescriptorAttributes;
use Genesis\Api\Traits\Request\Financial\FundingAttributes;
use Genesis\Api\Traits\Request\Financial\FxRateAttributes;
use Genesis\Api\Traits\Request\Financial\GamingAttributes;
use Genesis\Api\Traits\Request\Financial\NotificationAttributes;
use Genesis\Api\Traits\Request\Financial\ReferenceAttributes;
use Genesis\Api\Traits\Request\Financial\ScaAttributes;
use Genesis\Api\Traits\Request\Financial\TravelData\TravelDataAttributes;
use Genesis\Api\Traits\Request\MotoAttributes;
use Genesis\Api\Traits\Request\RiskAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Sale3D
 *
 * Sale 3D Request
 *
 * @package Genesis\Api\Request\Financial\Cards
 */
class Sale3D extends \Genesis\Api\Request\Base\Financial\Cards\CreditCard3D
{
    use AccountOwnerAttributes;
    use AddressInfoAttributes;
    use AsyncAttributes;
    use BusinessAttributes;
    use CryptoAttributes;
    use DescriptorAttributes;
    use FundingAttributes;
    use FxRateAttributes;
    use GamingAttributes;
    use ManagedRecurringAttributes;
    use MotoAttributes;
    use NotificationAttributes;
    use RecurringCategoryAttributes;
    use RecurringTypeAttributes;
    use ReferenceAttributes;
    use RiskAttributes;
    use ScaAttributes;
    use TravelDataAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::SALE_3D;
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
        return array_merge(
            array(
                'amount' => static::REQUEST_KEY_AMOUNT
            ),
            $this->getAllowedFieldsZeroValues()
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
            [
                'notification_url'   => ['return_success_url', 'return_failure_url'],
                'return_success_url' => ['notification_url', 'return_failure_url'],
                'return_failure_url' => ['notification_url', 'return_success_url']
            ],
            $this->requiredTokenizationFieldsConditional(),
            $this->requiredCCFieldsConditional(),
            $this->required3DSFieldsConditional(),
            $this->requiredManagedRecurringFieldsConditional(),
            $this->requiredRecurringManagedTypeFieldConditional()
        );

        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);

        $requiredFieldsGroups = array_merge(
            ['synchronous'  => ['notification_url', 'return_success_url', 'return_failure_url']],
            $this->required3DSFieldsGroups()
        );

        $this->requiredFieldsGroups = CommonUtils::createArrayObject($requiredFieldsGroups);
    }

    /**
     * Inject the requiredFieldsValuesConditional Validations
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        $requiredFieldsValuesConditional = $this->getThreedsV2FieldValuesValidations() +
            $this->requiredRecurringInitialTypesFieldValuesConditional();

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject($requiredFieldsValuesConditional);

        parent::checkRequirements();
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getTransactionAttributes()
    {
        return array_merge(
            [
                'gaming'                    => $this->gaming,
                'moto'                      => $this->moto,
                'notification_url'          => $this->notification_url,
                'return_success_url'        => $this->return_success_url,
                'return_failure_url'        => $this->return_failure_url,
                'customer_email'            => $this->customer_email,
                'customer_phone'            => $this->customer_phone,
                'document_id'               => $this->document_id,
                'billing_address'           => $this->getBillingAddressParamsStructure(),
                'shipping_address'          => $this->getShippingAddressParamsStructure(),
                'risk_params'               => $this->getRiskParamsStructure(),
                'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure(),
                'reference_id'              => $this->reference_id,
                'travel'                    => $this->getTravelData(),
                'fx_rate_id'                => $this->fx_rate_id,
                'crypto'                    => $this->crypto,
                'business_attributes'       => $this->getBusinessAttributesStructure(),
                'recurring_type'            => $this->getRecurringType(),
                'managed_recurring'         => $this->getManagedRecurringAttributesStructure(),
                'recurring_category'        => $this->recurring_category,
                'funding'                   => $this->getFundingAttributesStructure(),
                'account_owner'             => $this->getAccountOwnerAttributesStructure()
            ],
            $this->getScaAttributesStructure(),
            $this->get3DSTransactionAttributes()
        );
    }
}

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

use Genesis\API\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\API\Traits\Request\Financial\UcofAttributes;
use Genesis\API\Traits\Request\Financial\CryptoAttributes;
use Genesis\API\Traits\Request\Financial\FxRateAttributes;
use Genesis\API\Traits\Request\Financial\GamingAttributes;
use Genesis\API\Traits\Request\Financial\PreauthorizationAttributes;
use Genesis\API\Traits\Request\Financial\ScaAttributes;
use Genesis\API\Traits\Request\MotoAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\RiskAttributes;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;
use Genesis\API\Traits\Request\Financial\TravelData\TravelDataAttributes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Authorize
 *
 * Authorize Request
 *
 * @package Genesis\API\Request\Financial\Cards
 */
class Authorize extends \Genesis\API\Request\Base\Financial\Cards\CreditCard
{
    use GamingAttributes, MotoAttributes, AddressInfoAttributes, RiskAttributes, DescriptorAttributes,
        PreauthorizationAttributes, TravelDataAttributes, FxRateAttributes,
        CryptoAttributes, BusinessAttributes, RestrictedSetter, ScaAttributes, UcofAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::AUTHORIZE;
    }

    /**
     * Transaction Request with zero amount is allowed
     *
     * @return bool
     */
    protected function allowedZeroAmount()
    {
        return true;
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
                                     $this->requiredCCFieldsConditional();

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
                'gaming'                    => $this->gaming,
                'moto'                      => $this->moto,
                'preauthorization'          => var_export($this->preauthorization, true),
                'customer_email'            => $this->customer_email,
                'customer_phone'            => $this->customer_phone,
                'document_id'               => $this->document_id,
                'billing_address'           => $this->getBillingAddressParamsStructure(),
                'shipping_address'          => $this->getShippingAddressParamsStructure(),
                'risk_params'               => $this->getRiskParamsStructure(),
                'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure(),
                'travel'                    => $this->getTravelData(),
                'fx_rate_id'                => $this->fx_rate_id,
                'crypto'                    => $this->crypto,
                'business_attributes'       => $this->getBusinessAttributesStructure()
            ],
            $this->getScaAttributesStructure(),
            $this->getUcofAttributesStructure()
        );
    }
}

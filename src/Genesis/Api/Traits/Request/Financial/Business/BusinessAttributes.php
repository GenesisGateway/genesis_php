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

namespace Genesis\Api\Traits\Request\Financial\Business;

use Genesis\Api\Constants\Transaction\Parameters\Business\PaymentTypes;

/**
 * Trait BusinessAttributes
 * @package Genesis\Api\Traits\Request\Financial\Business
 *
 * @method string getBusinessPaymentType() The type of payment - can be either deposit or balance
 */
trait BusinessAttributes
{
    use AirlinesAirCarriersAttributes;
    use CarPlaneAndBoatRentalsAttributes;
    use CruiseLinesAttributes;
    use EventManagementAttributes;
    use FurnitureAttributes;
    use HotelsAndRealEstateRentalsAttributes;
    use TravelAgenciesAttributes;

    /**
     * The type of payment - can be either deposit or balance
     *
     * @var string $business_payment_type
     */
    protected $business_payment_type;

    /**
     * The type of payment - can be either deposit or balance
     *
     * @param string $value
     * @return $this
     */
    public function setBusinessPaymentType($value)
    {
        if (empty($value)) {
            $this->business_payment_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'business_payment_type',
            PaymentTypes::getAll(),
            $value,
            'Invalid Payment Type.'
        );
    }

    /**
     * @return array
     */
    public function getBusinessAttributesStructure()
    {
        return  array_merge(
            $this->getAirlinesAirCarriersAttributesStructure(),
            $this->getEventManagementAttributesStructure(),
            $this->getFurnitureAttributesStructure(),
            $this->getHotelsAndRealEstateRentalsAttributesStructure(),
            $this->getCarPlaneAndBoatRentalsAttributesStructure(),
            $this->getCruiseLinesAttributesStructure(),
            $this->getTravelAgenciesAttributesStructure(),
            [
                'payment_type' => $this->business_payment_type
            ]
        ) ;
    }
}

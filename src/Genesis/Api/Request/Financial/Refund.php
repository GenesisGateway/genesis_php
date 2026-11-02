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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\Refund\CreditReasonIndicatorParameters;
use Genesis\Api\Constants\Transaction\Parameters\Refund\TicketChangeIndicatorParameters;
use Genesis\Api\Traits\Request\Financial\BeneficiaryAttributes;
use Genesis\Api\Traits\Request\Financial\CommercialCardAttributes;
use Genesis\Api\Traits\Request\Financial\Installments\InstallmentAttributes;
use Genesis\Api\Traits\Request\Financial\Refund\BankAttributes;
use Genesis\Api\Traits\Request\Financial\Refund\TravelTicketAttributes;

/**
 * Class Refund
 *
 * Refund Request
 *
 * @package Genesis\Api\Request\Financial
 */
class Refund extends \Genesis\Api\Request\Base\Financial\Reference
{
    use BankAttributes;
    use BeneficiaryAttributes;
    use CommercialCardAttributes;
    use InstallmentAttributes;
    use TravelTicketAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::REFUND;
    }

    /**
     * Return the payment transaction structure
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            parent::getPaymentTransactionStructure(),
            $this->getTravelTicketAttributesStructure(),
            $this->getBeneficiaryAttributesStructure(),
            $this->getBankAttributesStructure(),
            $this->getInstallmentAttributesStructure(),
            $this->getCommercialCardAttributesStructure()
        );
    }

    /**
     * Extend the Refund Request Validations
     *
     * @return void
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateCommercialCardAttributes();
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
        return $this->getCommercialCardAllowedFieldsZeroValues();
    }
}

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

namespace Genesis\Api\Traits\Request\Financial\Refund;

use Genesis\Api\Constants\Transaction\Parameters\Refund\CreditReasonIndicatorParameters;
use Genesis\Api\Constants\Transaction\Parameters\Refund\TicketChangeIndicatorParameters;

/**
 * Trait TravelTicketAttributes
 * @package Genesis\Api\Traits\Request\Financial\Refund
 */
trait TravelTicketAttributes
{
    /**
     * This field indicates the reason for a credit to the cardholder.
     * Allowed values: A, B, P, O
     *
     * @var string $credit_reason_indicator_1
     */
    protected $credit_reason_indicator_1;

    /**
     * This field indicates the reason for a credit to the cardholder.
     * Allowed values: A, B, P, O
     *
     * @var string $credit_reason_indicator_2
     */
    protected $credit_reason_indicator_2;

    /**
     * This field will contain either a space or a code to indicate why a ticket was changed.
     * Allowed values: C, N
     *
     * @var string $ticket_change_indicator
     */
    protected $ticket_change_indicator;

    /**
     * This field indicates the reason for a credit to the cardholder.
     *
     * @param string $value
     *
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setCreditReasonIndicator1($value)
    {
        return $this->setCreditReasonIndicator('credit_reason_indicator_1', $value);
    }

    /**
     * This field indicates the reason for a credit to the cardholder.
     *
     * @param string $value
     *
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setCreditReasonIndicator2($value)
    {
        return $this->setCreditReasonIndicator('credit_reason_indicator_2', $value);
    }

    /**
     * Indicates why a ticket was changed
     *
     * @param string $value
     *
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setTicketChangeIndicator($value)
    {
        return $this->allowedOptionsSetter(
            'ticket_change_indicator',
            TicketChangeIndicatorParameters::getAll(),
            $value,
            'Invalid ticket change indicator.'
        );
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    protected function setCreditReasonIndicator($field, $value)
    {
        return $this->allowedOptionsSetter(
            $field,
            CreditReasonIndicatorParameters::getAll(),
            $value,
            'Invalid credit reason indicator.'
        );
    }

    /**
     * Returns structure with travel ticket attributes for Request
     *
     * @return array
     */
    protected function getTravelTicketAttributesStructure()
    {
        return [
            'travel' => [
                'ticket' => [
                    'credit_reason_indicator_1' => $this->credit_reason_indicator_1,
                    'credit_reason_indicator_2' => $this->credit_reason_indicator_2,
                    'ticket_change_indicator'   => $this->ticket_change_indicator,
                ]
            ]
        ];
    }
}

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

namespace Genesis\API\Traits\Request\Financial\TravelData;

/**
 * Trait ReferenceTicketAttributes
 * @package Genesis\API\Traits\Request\Financial\TravelData
 */
trait ReferenceTicketAttributes
{
    /**
     * Unique id of the ticket transaction
     *
     * @var string
     */
    protected $ac_ticket_reference_id;

    /**
     * This field will contain the Service Category Code for the primary type of service that has been provided.
     * MasterCard Allowed values: MISC, BG
     * Visa Allowed values:
     * MISC, BF, BG, CF, CG, CO, FF, GF, GT, IE, LG, MD, ML, OT, PA, PT, SA, SB, SF, ST, TS, UN, UP, WI
     *
     * @var string
     */
    protected $ac_type;

    /**
     * This field will contain the form number assigned by the carrier for the transaction.
     *
     * @var string
     */
    protected $ac_ticket_document_number;

    /**
     * If this purchase has a connection or relationship to another purchase, such as baggage fee for a passenger
     * transport ticket, this field must contain the document number for the other purchase.
     *
     * @var string
     */
    protected $ac_issued_with_ticket_number;

    /**
     * This field will contain the Service Category Code for the secondary type of service that has been provided.
     * Visa Allowed values:
     * MISC, BF, BG, CF, CG, CO, FF, GF, GT, IE, LG, MD, ML, OT, PA, PT, SA, SB, SF, ST, TS, UN, UP, WI
     *
     * @var string
     */
    protected $ac_sub_type;

    /**
     * @return array
     */
    public function getReferenceTicketStructure()
    {
        return [
                'ticket_reference_id'       => $this->ac_ticket_reference_id,
                'ticket_document_number'    => $this->ac_ticket_document_number,
                'issued_with_ticket_number' => $this->ac_issued_with_ticket_number
        ];
    }

    /**
     * @return array
     */
    public function getChargesStructure()
    {
        return [
            'charges' => [
                'charge' => [
                    'type'     => $this->ac_type,
                    'sub_type' => $this->ac_sub_type
                ]
            ]
        ];
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAcType($value)
    {
        return $this->setTravelType('ac_type', $value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAcSubType($value)
    {
        return $this->setTravelType('ac_sub_type', $value);
    }

    /**
     * @param $field
     * @param $value
     *
     * @return $this
     */
    protected function setTravelType($field, $value)
    {
        return $this->allowedOptionsSetter(
            $field,
            [
                'BF', 'BG', 'CF', 'CG', 'CO', 'FF', 'GF', 'GT', 'IE', 'LG', 'MD', 'ML', 'OT', 'PA', 'PT', 'SA', 'SB',
                'SF', 'ST', 'TS', 'UN', 'UP', 'WI'
            ],
            $value,
            'Invalid type.'
        );
    }
}

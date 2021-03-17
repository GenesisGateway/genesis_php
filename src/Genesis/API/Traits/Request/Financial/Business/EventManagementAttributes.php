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

namespace Genesis\API\Traits\Request\Financial\Business;

use Genesis\API\Constants\DateTimeFormat;

/**
 * Trait EventManagementAttributes
 * @package Genesis\API\Traits\Request\Financial\Business
 *
 * @method $this setBusinessEventOrganizerId($value) Set event organizer id
 * @method $this setBusinessEventId($value) Set event id
 */
trait EventManagementAttributes
{
    /**
     * The date when event starts
     *
     * @var string $business_event_start_date
     */
    protected $business_event_start_date;

    /**
     * The date when event ends
     *
     * @var string $business_event_end_date
     */
    protected $business_event_end_date;

    /**
     * The id of event organizer
     * @var string $business_event_organizer_id
     */
    protected $business_event_organizer_id;

    /**
     * The event id
     *
     * @var string $business_event_id
     */
    protected $business_event_id;

    /**
     *  Set the date when event starts
     *
     * @param  string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessEventStartDate($value)
    {
        if ($value === null) {
            $this->business_event_start_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_event_start_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_event_start_date.'
        );
    }

    /**
     *  Set the date when event ends
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessEventEndDate($value)
    {
        if ($value === null) {
            $this->business_event_end_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_event_end_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_event_end_date.'
        );
    }

    /**
     * @return string
     */
    public function getBusinessEventStartDate()
    {
        return empty($this->business_event_start_date) ?
            null : $this->business_event_start_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessEventEndDate()
    {
        return empty($this->business_event_end_date) ?
            null : $this->business_event_end_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getEventManagementAttributesStructure()
    {
        return [
            'event_start_date'   => $this->getBusinessEventStartDate(),
            'event_end_date'     => $this->getBusinessEventEndDate(),
            'event_organizer_id' => $this->business_event_organizer_id,
            'event_id'           => $this->business_event_id
        ];
    }
}

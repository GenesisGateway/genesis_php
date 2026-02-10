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

namespace Genesis\Api\Traits\Request\NonFinancial\Payee;

use DateTime;
use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait OwnerAttributes
 *
 * @method string getOwnerType()                     Get the type of the Owner
 * @method string getOwnerName()                     Get the Owner full name
 * @method string getOwnerCountry()                  Get the country code in ISO 3166
 * @method string getOwnerNotificationUrl()          Get the notification URL
 * @method string getOwnerRegistrationNumber()       Get the registration number
 * @method $this  setOwnerType($value)               Set the type of the Owner
 * @method $this  setOwnerName($value)               Set the Owner full name
 * @method $this  setOwnerCountry($value)            Set the country code in ISO 3166
 * @method $this  setOwnerNotificationUrl($value)    Set the notification URL
 * @method $this  setOwnerRegistrationNumber($value) Set the registration number
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Payee
 */
trait OwnerAttributes
{
    use AddressAttributes;

    /**
     * The type of the Owner. Can be company or person, director, ultimate_beneficial_owner
     *
     * @var string
     */
    protected $owner_type;

    /**
     * The Owner full name
     *
     * @var string
     */
    protected $owner_name;

    /**
     * Country code in ISO 3166. In case of person this should contain the country of birth.
     * In case of company this should contain the country of incorporation
     *
     * @var string
     */
    protected $owner_country;

    /**
     * Date of birth for an Owner of type person or the date of incorporation for an Owner of type company
     *
     * @var DateTime|null
     */
    protected $owner_date;

    /**
     * The URL to which the Owners API will send notifications (webhooks) about status changes of the Owner
     *
     * @var string
     */
    protected $owner_notification_url;

    /**
     * The registration number of an Owner of type company. Required only for Owner of type company
     *
     * @var string
     */
    protected $owner_registration_number;

    /**
     * Sets the owner date
     *
     * @param  string $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setOwnerDate($value)
    {
        if (empty($value)) {
            $this->owner_date = null;

            return $this;
        }

        return $this->parseDate(
            'owner_date',
            DateTimeFormat::getAll(),
            (string)$value,
            'Invalid format for Owner date'
        );
    }

    /**
     * Gets the owner date
     *
     * @return string|null
     */
    public function getOwnerDate()
    {
        $format = $this->owner_date ? DateTimeFormat::YYYY_MM_DD_H_I_S :
            DateTimeFormat::YYYY_MM_DD_ISO_8601;

        return (empty($this->owner_date)) ? null : $this->owner_date->format($format);
    }

    /**
     * Get Owner attributes structure
     *
     * @return array
     */
    protected function getOwnerAttributesStructure()
    {
        return [
            'type'                => $this->owner_type,
            'name'                => $this->owner_name,
            'country'             => $this->owner_country,
            'date'                => $this->getOwnerDate(),
            'notification_url'    => $this->owner_notification_url,
            'registration_number' => $this->owner_registration_number,
            'address'             => $this->getAddressAttributesStructure(),
        ];
    }
}

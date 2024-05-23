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

namespace Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait CustomerAttributes
 * @package Genesis\Api\Traits\Request\Financial\OnlineBankingPayments
 *
 * @method $this  setCompanyType($value)
 * @method $this  setCompanyActivity($value)
 * @method $this  setMothersName($value)
 * @method string getCompanyType()
 * @method string getCompanyActivity()
 * @method string getMothersName()
 */
trait CustomerAttributes
{
    /**
     * Company type of the customer. For Legal Person.
     *
     * @var string $company_type
     */
    protected $company_type;

    /**
     * Company activity of the customer. For Legal Person.
     *
     * @var string $company_activity
     */
    protected $company_activity;

    /**
     * The incorporation date of the customer. For Legal Person.
     *
     * @var \DateTime $incorporation_date
     */
    protected $incorporation_date;

    /**
     * Mother's name of the customer.
     *
     * @var string $mothers_name
     */
    protected $mothers_name;

    /**
     * Get incorporation date of the customer
     *
     * @return string|null
     */
    public function getIncorporationDate()
    {
        return (empty($this->incorporation_date)) ? null :
            $this->incorporation_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set incorporation date of the customer
     *
     * @param string $value
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setIncorporationDate($value)
    {
        if (empty($value)) {
            $this->incorporation_date = null;

            return $this;
        }

        return $this->parseDate(
            'incorporation_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for Incorporation Date.'
        );
    }

    /**
     * Builds an array list with all Params
     *
     * @return array
     */
    protected function getCustomerParamsStructure()
    {
        return [
            'company_type'       => $this->company_type,
            'company_activity'   => $this->company_activity,
            'incorporation_date' => $this->getIncorporationDate(),
            'mothers_name'       => $this->mothers_name
        ];
    }
}

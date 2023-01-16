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

namespace Genesis\API\Traits\Request\Financial;

use Genesis\API\Constants\DateTimeFormat;

/**
 * Trait BirthDateAttributes
 * @package Genesis\API\Traits\Request\Financial
 */
trait BirthDateAttributes
{
    /**
     * Birth date of the customer
     *
     * @var \DateTime $birth_date
     */
    protected $birth_date;

    /**
     * Birth date of the customer
     *
     * @return string|null
     */
    public function getBirthDate()
    {
        return (empty($this->birth_date)) ? null :
            $this->birth_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * Birth date of the customer
     *
     * @param string $value
     * @return $this
     */
    public function setBirthDate($value)
    {
        if (empty($value)) {
            $this->birth_date = null;

            return $this;
        }

        return $this->parseDate(
            'birth_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for Birth Date.'
        );
    }
}

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

namespace Genesis\API\Traits;

use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * Trait RestrictedSetter
 * @package Genesis\API\Traits
 */
trait RestrictedSetter
{
    /**
     * @param $field
     * @param $allowed
     * @param $value
     * @param $errorMessage
     *
     * @return $this
     * @throws InvalidArgument
     */
    protected function allowedOptionsSetter($field, $allowed, $value, $errorMessage)
    {
        if (!in_array($value, $allowed)) {
            throw new InvalidArgument($errorMessage . ' Allowed values are ' . implode(', ', $allowed));
        }

        $this->$field = $value;

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @param int/null $min
     * @param int/null $max
     *
     * @return $this
     * @throws InvalidArgument
     */
    protected function setLimitedString($field, $value, $min = null, $max = null)
    {
        $len = strlen($value);

        if ($min !== null && $len < $min) {
            throw new InvalidArgument("$field value must be at least $min chars long.");
        }
        if ($max !== null && $len > $max) {
            throw new InvalidArgument("$field value must be max $max chars long.");
        }

        $this->$field = $value;

        return $this;
    }

    /**
     * @param $field
     * @param array $formats
     * @param $value
     * @param $errorMessage
     *
     * @return $this
     * @throws InvalidArgument
     */
    protected function parseDate($field, $formats, $value, $errorMessage)
    {
        $date = false;

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $value);

            if ($date instanceof \DateTime) {
                break;
            }
        }

        if (!$date) {
            throw new InvalidArgument($errorMessage . ' Allowed format is ' . implode(' or ', $formats));
        }

        $this->$field = $date;

        return $this;
    }

    /**
     * @param string $field
     * @param $value
     * @throws InvalidArgument
     * @return $this
     */
    protected function parseAmount($field, $value)
    {
        if (is_null($value)) {
            $this->{$field} = null;
            return $this;
        }

        $value = trim($value);

        if (!\Genesis\Utils\Common::isValidAmount($value)) {
            throw new InvalidArgument(
                sprintf(
                    'Unsupported value %s for parameter %s. ' .
                    'Please check the documentation for more information.',
                    $value,
                    $field
                )
            );
        }
        $this->{$field} = $value;

        return $this;
    }
}

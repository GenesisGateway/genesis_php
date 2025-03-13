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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait ModeAttribute
 * @package Genesis\Api\Traits\Request\NonFinancial
 *
 * @method int getMode() Get the mode
 */
trait ModeAttribute
{
    /**
     * Mode parameter for list requests
     *
     * @var int $mode
     */
    protected $mode;

    /**
     * Set mode
     *
     * @param $value
     * @throws InvalidArgument
     * @return $this
     */
    public function setMode($value)
    {
        if (empty($value)) {
            $this->mode = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'mode',
            ['list'],
            $value,
            'Invalid Mode value'
        );
    }
}

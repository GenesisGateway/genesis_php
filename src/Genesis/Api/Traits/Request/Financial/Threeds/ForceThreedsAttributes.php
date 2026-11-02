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

namespace Genesis\Api\Traits\Request\Financial\Threeds;

use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Trait ForceThreedsAttributes
 * @package Genesis\Api\Traits\Request\Financial\Threeds
 *
 * @method bool|null getForceThreeds() Force 3DSv2 authentication in case no 3DSv2 params are sent
 */
trait ForceThreedsAttributes
{
    /**
     * Force 3DSv2 authentication in case no 3DSv2 params are sent
     *
     * @var bool|null $force_threeds
     */
    protected $force_threeds;

    /**
     * Force 3DSv2 authentication in case no 3DSv2 params are sent
     *
     * @param mixed $value Boolean-like value or null to clear
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setForceThreeds($value)
    {
        if ($value === null) {
            $this->force_threeds = null;

            return $this;
        }

        // filterBoolean() returns the original input when it cannot be resolved to a bool
        $parsed = CommonUtils::filterBoolean($value);

        if (!is_bool($parsed)) {
            throw new InvalidArgument('Invalid force_threeds value. Allowed values are true or false.');
        }

        $this->force_threeds = $parsed;

        return $this;
    }

    /**
     * Force 3DS request structure
     *
     * @return array
     */
    protected function getForceThreedsStructure()
    {
        return [
            'force_threeds' => $this->force_threeds
        ];
    }
}

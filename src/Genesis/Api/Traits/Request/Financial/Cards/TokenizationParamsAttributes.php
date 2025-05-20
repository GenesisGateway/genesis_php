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

namespace Genesis\Api\Traits\Request\Financial\Cards;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait TokenizationParamsAttributes
 *
 * @package Genesis\Api\Traits\Request\Financial\Cards
 *
 * @method string getTokenizationTavv()
 * @method string getTokenizationEci()
 * @method setTokenizationTavv(string $tavv)
 */
trait TokenizationParamsAttributes
{
    /**
     * Tokenization tavv
     *
     * @var string
     */
    protected $tokenization_tavv;

    /**
     * Tokenization eci
     *
     * @var string
     */
    protected $tokenization_eci;

    /**
     * Set the tokenization eci
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setTokenizationEci($value)
    {
        if ($value === null) {
            $this->tokenization_eci = null;

            return $this;
        }

        return $this->setLimitedString('tokenization_eci', $value, null, 2);
    }

    /**
     * Return the tokenization parameters attributes structure
     *
     * @return array
     */
    protected function tokenizationParamsAttributesStructure()
    {
        return [
            'tavv' => $this->tokenization_tavv,
            'eci'  => $this->tokenization_eci
        ];
    }
}

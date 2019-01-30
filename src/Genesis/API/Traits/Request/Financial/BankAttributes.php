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

namespace Genesis\API\Traits\Request\Financial;

use Genesis\Exceptions\ErrorParameter;

/**
 * Trait BankAttributes
 * @package Genesis\API\Traits\Request\Financial
 *
 */
trait BankAttributes
{
    /**
     * @return array
     */
    public function getAllowedBicSizes()
    {
        return [8, 11];
    }

    /**
     * Must contain valid IBAN, check
     * in the official API documentation
     *
     * @var string
     */
    protected $iban;

    /**
     * Must contain valid BIC, check
     * in the official API documentation
     *
     * @var string
     */
    protected $bic;

    /**
     * SWIFT/BIC code of the customer’s bank
     *
     * @param $value
     *
     * @return $this
     * @throws ErrorParameter
     */
    public function setBic($value)
    {
        if (in_array(strlen($value), $this->getAllowedBicSizes()) === false) {
            throw new ErrorParameter(
                'Bic must be with one of these lengths: ' . implode(', ', $this->getAllowedBicSizes())
            );
        }

        $this->bic = $value;

        return $this;
    }
}

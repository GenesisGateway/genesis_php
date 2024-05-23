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

use Genesis\Exceptions\ErrorParameter;

/**
 * Trait PproAttributes
 *
 * Trait with common fields for PPRO payment types
 *
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method string getConsumerReference()
 * @method string getNationalId()
 */
trait PproAttributes
{
    /**
     * @return int
     */
    public function getMaxConsumerReferenceLen()
    {
        return 20;
    }

    /**
     * @return int
     */
    public function getNationalIdLen()
    {
        return 20;
    }

    /**
     * Consumer reference is a unique consumer identifier
     *
     * @var string
     */
    protected $consumer_reference;

    /**
     * National Identifier number of the customer
     *
     * @var string
     */

    protected $national_id;

    /**
     * Unique consumer identifier
     *
     * @param string $value
     *
     * @return $this
     * @throws ErrorParameter
     */
    public function setConsumerReference($value)
    {
        if (strlen((string)$value) > $this->getMaxConsumerReferenceLen()) {
            throw new ErrorParameter("Consumer reference can be max {$this->getMaxConsumerReferenceLen()} characters.");
        }

        $this->consumer_reference = $value;

        return $this;
    }

    /**
     * National Identifier number of the customer
     *
     * @param string $value
     *
     * @return $this
     * @throws ErrorParameter
     */
    public function setNationalId($value)
    {
        if (strlen((string)$value) > $this->getNationalIdLen()) {
            throw new ErrorParameter("National Identifier can be max {$this->getNationalIdLen()} characters.");
        }

        $this->national_id = $value;

        return $this;
    }
}

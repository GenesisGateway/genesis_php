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

namespace Genesis\API\Traits\Request\CustomerAddress;

use Genesis\Exceptions\ErrorParameter;

/**
 * Trait CustomerInfoAttributes
 * @package Genesis\API\Traits\Request\CustomerAddress
 *
 * @method $this setCustomerPhone($value) Set Phone number of the Customer
 */
trait CustomerInfoAttributes
{
    /**
     * Email address of the Customer
     *
     * @var string
     */
    protected $customer_email;

    /**
     * @param string $value
     *
     * @return $this
     * @throws ErrorParameter
     */
    public function setCustomerEmail($value)
    {
        if ($value !== null && filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new ErrorParameter('Please, enter a valid email');
        }

        $this->customer_email = $value;
        return $this;
    }

    /**
     * Phone number of the customer
     *
     * @var string
     */
    protected $customer_phone;
}

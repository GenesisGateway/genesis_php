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

namespace Genesis\API\Traits\Request\NonFinancial;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait TokenizationApiAttributes
 *
 * @package Genesis\API\Traits\Request\NonFinancial
 *
 * @method $this setTokenType($value) Set Token type format
 * @method string getConsumerId() Get Consumer unique reference
 * @method string getEmail() Get Consumer e-mail address
 * @method string getTokenType() Get Token type format
 */
trait TokenizationApiAttributes
{
    /**
     * Consumer unique reference
     *
     * @var string
     */
    protected $consumer_id;

    /**
     * Consumer e-mail address
     *
     * @var string
     */
    protected $email;

    /**
     * Token type format
     *
     * @var string
     */
    protected $token_type;

    /**
     * @param string $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setConsumerId($value)
    {
        return $this->setLimitedString(
            'consumer_id',
            $value,
            1,
            10
        );
    }

    /**
     * @param string $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setEmail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgument('Invalid email given');
        }

        $this->email = $value;

        return $this;
    }
}

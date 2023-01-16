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

namespace Genesis\API\Traits\Request;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait TokenizationAttributes
 * @package Genesis\API\Traits\Request
 *
 * @method string setConsumerId($value)
 * @method bool getRememberCard()
 * @method $this setToken($value) Set token of the card holder details
 */
trait TokenizationAttributes
{

    /**
     * Consumer unique reference
     *
     * @var string
     */
    protected $consumer_id;

    /**
     * Check documentation section Tokenize. Offer the user the option to save
     * cardholder details for future use (tokenize).
     *
     * @var string
     */
    protected $remember_card = false;

    /**
     * Token of the card holder details
     *
     * @var string
     */
    protected $token;

    /**
     * @param bool $flag
     *
     * @return $this
     */
    public function setRememberCard($flag)
    {
        $this->remember_card = \Genesis\Utils\Common::toBoolean($flag);

        return $this;
    }

    protected function getTokenizationStructure()
    {
        return [
            'token'         => $this->token,
            'consumer_id'   => $this->consumer_id,
            'remember_card' =>  \Genesis\Utils\Common::toBoolean($this->remember_card)
        ];
    }
}

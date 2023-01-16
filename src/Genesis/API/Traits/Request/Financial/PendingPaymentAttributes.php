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

use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Trait PendingPaymentAttributes
 * @package Genesis\API\Traits\Request\Financial
 *
 * @method string getReturnPendingUrl() URL where customer is sent to when asynchronous payment is pending
 */
trait PendingPaymentAttributes
{
    /**
     * URL where customer is sent to when asynchronous payment is pending confirmation
     *
     * @var string $return_pending_url
     */
    protected $return_pending_url;

    /**
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setReturnPendingUrl($value)
    {
        if (empty($value)) {
            $this->return_pending_url = null;

            return $this;
        }
        if (!CommonUtils::isValidUrl($value)) {
            throw new InvalidArgument('Invalid url is given.');
        }

        $this->return_pending_url = $value;

        return $this;
    }
}

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

namespace Genesis\Api\Request\Base\NonFinancial\Fx;

use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Builder;

/**
 * Class BaseRequest
 *
 * Genesis Fx(Forex) Services provides the ability to retrieve up-to-date Fx rates.
 * The API is synchronous and is based on RESTFul practices.
 * Be sure to set Content-type: application/json in your headers.
 *
 * To interact with the Fx API, you need to provide login credentials using standard HTTP Basic Authentication.
 * (credentials can be found in your Admin interface.)
 *
 * @package Genesis\Api\Request\Base\NonFinancial\Fx
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    const MAIN_REQUEST_PATH = 'fx';

    /**
     * Fx constructor.
     *
     * @param string $requestPath
     */
    public function __construct($requestPath)
    {
        parent::__construct(static::MAIN_REQUEST_PATH . '/' . $requestPath, Builder::JSON, ['v1']);
    }
}

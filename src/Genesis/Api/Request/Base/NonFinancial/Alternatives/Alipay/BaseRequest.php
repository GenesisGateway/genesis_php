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

namespace Genesis\Api\Request\Base\NonFinancial\Alternatives\Alipay;

use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;

/**
 * Class BaseRequest
 *
 * Alipay APM Services
 *
 * @package Genesis\Api\Request\Base\NonFinancial\Alternatives\Alipay
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    /**
     * Alipay APM Services path segment
     */
    const SERVICE_PATH = 'alipay';

    /**
     * @param string $requestPath Alipay service action (e.g. register_merchant)
     */
    public function __construct($requestPath)
    {
        parent::__construct(self::SERVICE_PATH . '/' . $requestPath, Builder::JSON, ['v1']);
    }

    /**
     * Set the per-request configuration
     *
     * Enables the terminal token in the URL: {version}/alipay/{action}/{terminal_token}/
     *
     * @return void
     * @throws EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        parent::initConfiguration();

        $this->initApiGatewayConfiguration("{$this->getVersion()}/{$this->getRequestPath()}", true);
    }
}

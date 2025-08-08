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

namespace Genesis\Api\Request\Base\NonFinancial\Payee;

use Genesis\Api\Request;
use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class BaseRequest
 *
 * Payee-related data is created and used to process payout payments to specific Payee accounts.
 *
 * @package Genesis\Api\Request\Base\NonFinancial\Payee
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    /**
     * Payee constructor.
     *
     * @param string $request_path
     */
    public function __construct($request_path)
    {
        parent::__construct($request_path);
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        parent::initConfiguration();
        $this->initApiGatewayConfiguration($this->getRequestPath(), false, 'api_service');
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $this->treeStructure = CommonUtils::createArrayObject(
            $this->getRequestStructure()
        );
    }

    /**
     * Set Request GET method
     *
     * @return void
     */
    protected function setGetRequest()
    {
        $this->config = CommonUtils::createArrayObject(
            [
                'protocol'      => Request::PROTOCOL_HTTPS,
                'port'          => Request::PORT_HTTPS,
                'type'          => Request::METHOD_GET,
                'format'        => Builder::JSON,
                'authorization' => Request::AUTH_TYPE_BASIC
            ]
        );
    }

    /**
     * Set Request PATCH method
     *
     * @return void
     */
    protected function setPatchRequest()
    {
        $this->config = CommonUtils::createArrayObject(
            [
                'protocol'      => Request::PROTOCOL_HTTPS,
                'port'          => Request::PORT_HTTPS,
                'type'          => Request::METHOD_PATCH,
                'format'        => Builder::JSON,
                'authorization' => Request::AUTH_TYPE_BASIC
            ]
        );
    }
}

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

namespace Genesis\Api\Request\Base\NonFinancial\Reconcile;

use Genesis\Api\Request;
use Genesis\Config;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Base Abstract Class for all Reconcile Requests
 *
 * @package Genesis\Api\Request\Base\NonFinancial\Reconcile
 *
 * @method bool getUseSmartRouter() Get Smart Router usage.
 */
abstract class BaseRequest extends Request
{
    /**
     * Path to the API endpoint
     *
     * @var string
     */
    protected $path;

    /**
     * Force Smart Router endpoint for Financial transactions
     *
     * @var bool
     */
    protected $use_smart_router = false;

    /**
     * Use Smart Router endpoint for Financial transactions
     *
     * @param $value
     * @return $this
     */
    public function setUseSmartRouter($value)
    {
        $this->use_smart_router = CommonUtils::toBoolean($value);

        return $this;
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
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration($this->path);
    }

    /**
     * Process Request Params
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function processRequestParameters()
    {

        if ($this->getUseSmartRouter() || Config::getForceSmartRouting()) {
            $this->initApiGatewayConfiguration($this->path, false, 'api_service');
        }

        parent::processRequestParameters();
    }
}

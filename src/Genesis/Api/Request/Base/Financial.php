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

namespace Genesis\Api\Request\Base;

use Genesis\Api\Traits\Request\BaseAttributes;
use Genesis\Config;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Financial
 *
 * Base Abstract Class for all Financial Requests
 *
 * @package Genesis\Api\Request\Base
 *
 * @method getUseSmartRouter() Get Smart Router usage. Whether Financial transaction endpoint is a Smart Router or not.
 */
abstract class Financial extends \Genesis\Api\Request
{
    use BaseAttributes;

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
     * Returns the Request transaction type
     * @return string
     */
    abstract protected function getTransactionType();

    /**
     * Return additional request attributes
     * @return array
     */
    abstract protected function getPaymentTransactionStructure();

    /**
     * Initialize per-request configuration
     *
     * @throws EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration();

        if (Config::getForceSmartRouting()) {
            $this->initializeSmartRouter();
        }
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
        if ($this->getUseSmartRouter()) {
            $this->initializeSmartRouter();
        }

        parent::processRequestParameters();
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'payment_transaction' => [
                'transaction_type' => $this->getTransactionType(),
                'transaction_id'   => $this->transaction_id,
                'usage'            => $this->usage,
                'remote_ip'        => $this->remote_ip
            ]
        ];

        $treeStructure['payment_transaction'] += $this->getPaymentTransactionStructure();

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }

    /**
     * Initialize Smart Router endpoint
     *
     * @return void
     * @throws \Genesis\Exceptions\EnvironmentNotSet
     */
    protected function initializeSmartRouter()
    {
        $this->initApiGatewayConfiguration('transactions', false, 'api_service');
    }
}

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

namespace Genesis\Api\Request\Base\NonFinancial\Kyc;

use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class BaseRequest
 *
 * Genesis KYC Services gives us the ability to perform particular checks on the integrity of the consumer data.
 * Based on the returned consumer score we can decide whether we want to reject/approve a given transaction
 * or perform another action for this consumer.
 *
 * @package Genesis\Api\Request\Base\NonFinancial\Kyc
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    /**
     * @var string
     */
    private $request_path;

    /**
     * Kyc constructor.
     *
     * @param string $requestPath
     */
    public function __construct($requestPath)
    {
        $this->request_path = $requestPath;

        parent::__construct($this->request_path, Builder::JSON, ['v1']);
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     * @throws EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        parent::initConfiguration();
        $this->initApiGatewayConfiguration("api/{$this->getVersion()}/$this->request_path", false, 'kyc');
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
}

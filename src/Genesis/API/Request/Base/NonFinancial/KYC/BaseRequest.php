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

namespace Genesis\API\Request\Base\NonFinancial\KYC;

use Genesis\API\Request\Base\BaseVersionedRequest;
use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\API\Constants\NonFinancial\KYC\Genders;

/**
 * Class BaseRequest
 *
 * Genesis KYC Services gives us the ability to perform particular checks on the integrity of the consumer data.
 * Based on the returned consumer score we can decide whether we want to reject/approve a given transaction
 * or perform another action for this consumer.
 *
 * @package Genesis\API\Request\Base\NonFinancial\KYC
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    /**
     * @var string
     */
    private $request_path;

    /**
     * Switch between KYC and Gate
     *
     * @var string
     */
    private $kyc_subdomain;

    /**
     * KYC constructor.
     *
     * @param string $requestPath
     */
    public function __construct($requestPath)
    {
        $this->request_path = $requestPath;
        $this->kyc_subdomain = 'kyc';

        parent::__construct($this->request_path, Builder::JSON, ['v1']);
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     * @throws EnvironmentNotSet
     * @SuppressWarnings("unused")
     */
    protected function initConfiguration($subdomain = 'kyc')
    {
        parent::initConfiguration($this->kyc_subdomain);
        $this->initApiGatewayConfiguration('api/' . $this->getVersion() . '/' . $this->request_path,false, $this->kyc_subdomain);  // @codingStandardsIgnoreLine
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $this->treeStructure = \Genesis\Utils\Common::createArrayObject(
            $this->getRequestStructure()
        );
    }
}

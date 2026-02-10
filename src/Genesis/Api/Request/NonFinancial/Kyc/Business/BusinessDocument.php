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

namespace Genesis\Api\Request\NonFinancial\Kyc\Business;

use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest as KYCBaseRequest;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class BusinessDocument
 *
 * Get a specific document related to the business entity.
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\Business
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class BusinessDocument extends KYCBaseRequest
{
    /**
     * The unique identifier of the Business.
     *
     * @var string
     *
     */
    protected $business_id;

    /**
     * The unique identifier of the Document returned in the list of documents.
     *
     * @var string
     */
    protected $id;

    /**
     * BusinessDocument constructor
     *
     */
    public function __construct()
    {
        parent::__construct('businesses');
    }

    /**
     * Set business_id and modify the request URL
     *
     * @param $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setBusinessId($value)
    {
        $this->business_id = $value;

        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                'kyc',
                "api/{$this->getVersion()}/{$this->getRequestPath()}/{$this->business_id}/documents/{$this->id}"
            )
        );

        return $this;
    }

    /**
     * Set id and modify the request URL
     *
     * @param $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setId($value)
    {
        $this->id = $value;

        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                'kyc',
                "api/{$this->getVersion()}/{$this->getRequestPath()}/{$this->business_id}/documents/{$this->id}"
            )
        );

        return $this;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'business_id',
            'id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Create the request's Tree structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}

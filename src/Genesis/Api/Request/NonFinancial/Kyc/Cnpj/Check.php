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

namespace Genesis\Api\Request\NonFinancial\Kyc\Cnpj;

use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Check
 *
 * Check the status of a specific Brazilian company's CNPJ number
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\Cnpj
 *
 * @method string getDocumentId()
 */
class Check extends BaseRequest
{
    /**
     * CNPJ number
     *
     * @var string
     */
    protected $document_id;

    public function __construct()
    {
        parent::__construct('cnpj');
    }

    /**
     * Set document_id and modify the request URL
     *
     * @param $value
     * @throws EnvironmentNotSet
     * @return $this
     */
    public function setDocumentId($value)
    {
        $this->document_id = $value;

        $this->setApiConfig(
            'url',
            $this->buildRequestURL('kyc', "api/{$this->getVersion()}/{$this->getRequestPath()}/$this->document_id")
        );

        return $this;
    }

    /**
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'document_id'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}

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

namespace Genesis\Api\Request\NonFinancial\Installments;

use Genesis\Api\Request;
use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Builder;
use Genesis\Utils\Common;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Installment Show
 *
 * Installments show request
 *
 * @package Genesis\Api\Request\NonFinancial\Installments
 */
class Show extends BaseVersionedRequest
{
    const REQUEST_PATH = 'installments/:installment_id';

    /**
     * Installment id
     *
     * @var string
     */
    protected $installment_id;

    /**
     * Installment Show constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Installment id setter
     *
     * @param string $value
     *
     * @return $this
     */
    public function setInstallmentId($value)
    {
        $this->installment_id = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with proper installment id
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':installment_id',
                (string) $this->installment_id,
                self::REQUEST_PATH
            )
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'installment_id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }


    /**
     * Configures a Secured Post Request with JSON body
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->config = Common::createArrayObject(
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
     * Return the request structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}

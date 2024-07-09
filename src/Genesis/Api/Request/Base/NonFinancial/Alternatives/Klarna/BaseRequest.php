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

namespace Genesis\Api\Request\Base\NonFinancial\Alternatives\Klarna;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Request;
use Genesis\Api\Traits\Request\NonFinancial\PagingAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Common;

/**
 * Class BaseRequest
 * @package Genesis\Api\Request\Base\NonFinancial\Alternatives\Klarna
 */
abstract class BaseRequest extends Request
{
    /**
     * Unique transaction id defined by merchant
     *
     * @var string
     */
    protected $transaction_id;

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = array_merge(
            ['transaction_id'],
            $this->setRequestRequiredFields()
        );

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }

    protected function initBaseConfiguration($requestPath)
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration($requestPath, false);
    }

    protected function populateStructure()
    {
        $treeStructure = [
            $this->getParentNode() => array_merge(
                [
                    'transaction_id' => $this->transaction_id
                ],
                $this->getRequestStructure()
            )
        ];

        $this->treeStructure = Common::createArrayObject($treeStructure);
    }

    /**
     * Get additional attributes
     *
     * @return array
     */
    abstract protected function getRequestStructure();

    /**
     * Set additional required fields
     *
     * @return array
     */
    abstract protected function setRequestRequiredFields();

    /**
     * Get the root node of the Populated XML structure
     *
     * @return string
     */
    abstract protected function getParentNode();
}

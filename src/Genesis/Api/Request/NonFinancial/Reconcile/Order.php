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

namespace Genesis\Api\Request\NonFinancial\Reconcile;

use Genesis\Api\Request\Base\NonFinancial\Reconcile\BaseRequest;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Reconcile request by order_id
 *
 * Returns all payment transactions associated with a merchant order identifier
 * in a single, un-paginated response.
 *
 * @package    Genesis
 * @subpackage Request
 *
 * @method string getOrderId() Get the merchant order identifier to filter by
 */
class Order extends BaseRequest
{
    /**
     * Maximum allowed length of the order_id value
     */
    const ORDER_ID_MAX_LENGTH = 255;

    /**
     * The merchant order identifier to filter by
     *
     * @var string
     */
    protected $order_id;

    /**
     * Set the merchant order identifier to filter by
     *
     * @param string|null $value
     *
     * @return $this
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setOrderId($value)
    {
        if ($value === null) {
            $this->order_id = null;

            return $this;
        }

        return $this->setLimitedString('order_id', $value, null, self::ORDER_ID_MAX_LENGTH);
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
        $this->path = 'reconcile/by_order';

        parent::initConfiguration();
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'order_id'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'reconcile' => [
                'order_id' => $this->order_id
            ]
        ];

        $this->treeStructure = CommonUtils::createArrayObject($treeStructure);
    }
}

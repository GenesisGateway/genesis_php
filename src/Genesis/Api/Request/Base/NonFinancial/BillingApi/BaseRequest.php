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

namespace Genesis\Api\Request\Base\NonFinancial\BillingApi;

use Genesis\Api\Request\Base\GraphqlRequest;
use Genesis\Api\Traits\Request\NonFinancial\BillingApi\OrderByDirection;
use Genesis\Api\Traits\Request\NonFinancial\DateAttributes;
use Genesis\Api\Traits\Request\NonFinancial\PagingAttributes;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Class BaseRequest
 *
 * @package Genesis\Api\Request\Base\NonFinancial\BillingApi
 */
abstract class BaseRequest extends GraphqlRequest
{
    use DateAttributes;
    use PagingAttributes;
    use OrderByDirection;

    const MAX_DAYS_DIFFERENCE = 7;

    /**
     * List of billing statement IDs
     *
     * @var string[]
     */
    protected $billing_statement = [];

    /**
     * Field result collection is sorted by
     *
     * @var string
     */
    protected $order_by_field;

    /**
     * Set the list of Billing statement IDs in the filter
     *
     * @param array $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setBillingStatement($value)
    {
        if (empty($value)) {
            $this->billing_statement = [];
            return $this;
        }

        return $this->parseArrayOfStrings('billing_statement', $value, 'BillingStatement');
    }

    /**
     * Return a formatted string with the Billing statement IDs
     *
     * @return string
     */
    public function getBillingStatement()
    {
        if (empty($this->billing_statement)) {
            return '';
        }

        return sprintf('["%s"]', implode('","', $this->billing_statement));
    }

    /**
     * Set order by field
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setOrderByField($value)
    {
        return $this->allowedOptionsSetter(
            'order_by_field',
            $this->getOrderByFieldAllowedValues(),
            $value,
            'Invalid value given for orderByField. Allowed values: ' .
            implode(', ', $this->getOrderByFieldAllowedValues())
        );
    }

    /**
     * Set Service API token
     *
     * @return void
     */
    protected function initGraphqlToken()
    {
        $this->setApiConfig('bearer_token', Config::getBillingApiToken());
    }

    /**
     * Additional optional filter arguments
     *
     * @return string
     */
    protected function getAdditionalArguments()
    {
        $parts = array_filter([
            $this->getRequestOrder(),
            $this->getRequestPaging()
        ]);
        return implode(' ', $parts);
    }

    /**
     * Validate max number of elements in array
     *
     * @param array  $var
     * @param int    $maxSize
     * @param string $message
     *
     * @return void
     *
     * @throws ErrorParameter
     */
    protected function checkArrayMaxSize($var, $maxSize, $message)
    {
        if (!empty($var) && count($var) > $maxSize) {
            throw new ErrorParameter(
                sprintf('Max number of %s elements allowed is %s.', $message, $maxSize)
            );
        }
    }

    /**
     * Generate the request paging part of the GraphQL query
     *
     * @return string
     */
    protected function getRequestPaging()
    {
        $paging = [];

        if ($this->getPage()) {
            $paging['page'] = $this->getPage();
        }

        if ($this->getPerPage()) {
            $paging['perPage'] = $this->getPerPage();
        }

        return $this->generateGraphQLCode($paging, 'paging');
    }

    /**
     * Generate the request order part of the GraphQL query
     *
     * @return string
     */
    protected function getRequestOrder()
    {
        $elements = [];

        if ($this->getOrderByDirection()) {
            $elements['byDirection'] = $this->getOrderByDirection();
        }

        if (property_exists($this, 'order_by_field') && $this->order_by_field) {
            $elements['byField'] = $this->order_by_field;
        }

        return $this->generateGraphQLCode($elements, 'sort');
    }
}

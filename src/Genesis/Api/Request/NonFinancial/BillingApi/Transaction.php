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

namespace Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Api\Request\Base\GraphqlRequest;
use Genesis\Api\Traits\Request\NonFinancial\BillingApi\OrderByDirection;
use Genesis\Api\Traits\Request\NonFinancial\DateAttributes;
use Genesis\Api\Traits\Request\NonFinancial\PagingAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Transaction
 *
 * Billing Transactions API request
 * @package Genesis\Api\Request\NonFinancial\BillingApi
 *
 * @method $this  setUniqueId($value)
 * @method string getUniqueId()
 * @method string getOrderByField()
 */
class Transaction extends GraphqlRequest
{
    use DateAttributes;
    use OrderByDirection;
    use PagingAttributes;

    const MAX_COUNT_BILLING_STATEMENTS_FILTER = 10;

    /**
     * Request filter parameter:
     * Billing transaction unique ID
     *
     * @var string
     */
    protected $unique_id;

    /**
     * Request filter parameter:
     * List of billing statement IDs. Max number of elements allowed is 10.
     *
     * @var array
     */
    protected $billing_statement_id = [];

    /**
     * Field result collection is sorted by.
     * Default value: transactionDate
     *
     * @var string
     */
    protected $order_by_field;

    public function __construct()
    {
        parent::__construct('billing_transactions', 'billingTransactions');
    }

    /**
     * Set the list of billing statement IDs in the filter
     *
     * @param array $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBillingStatementId($value)
    {
        if (CommonUtils::isValidArray($value)) {
            $this->billing_statement_id = array_map('intval', $value);

            return $this;
        }

        throw new InvalidArgument(
            'BillingStatementId should be an array of integers'
        );
    }

    /**
     * Return a formatted string with the Billing statement IDs
     *
     * @return string
     */
    public function getBillingStatementId()
    {
        if (empty($this->billing_statement_id)) {
            return '';
        }

        return sprintf('[%s]', implode(',', $this->billing_statement_id));
    }

    /**
     * Set order by field parameter
     *
     * @param string $value
     * @return $this
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
     * List of allowed response fields
     *
     * @return string[]
     */
    protected function getResponseFieldsAllowedValues()
    {
        return ['uniqueId', 'billingStatementId', 'billingStatementDisplayId', 'transactionType',
            'transactionDate', 'transactionCurrency', 'transactionAmount', 'exchangeRate', 'billingCurrency',
            'billingAmount', 'transactionFeeCurrency', 'transactionFeeAmount', 'commissionAmount', 'commissionRuleId',
            'transactionFeeChargedOnBillingStatementId', 'commissionPercent',  'interchangeFee', 'interchangeCurrency',
            'isInterchangeplusplus', 'interchangeplusplusChargedOnBillingStatementId', 'schemeFee', 'vatAmount',
            'vatRate', 'schemeFeeCurrency', 'standardDebitCardRate', 'gstAmount', 'gstRate', 'terminalId', 'region',
            'settlementStatements', 'settlementDates', 'settlementStatus', 'merchantId', 'merchantName', 'valueDate'];
    }

    /**
     * List of allowed fields for response sorting
     *
     * @return string[]
     */
    protected function getOrderByFieldAllowedValues()
    {
        return ['billingStatementId', 'transactionDate', 'transactionCurrency', 'transactionAmount',
            'terminalId', 'exchangeRate', 'billingAmount', 'transactionFeeAmount', 'commissionPercent',
            'commissionAmount', 'commissionRuleId', 'interchangeFee', 'region', 'settlementStatus'];
    }

    /**
     * Set Service API token
     *
     * @return void
     */
    protected function initGraphqlToken()
    {
        $this->setApiConfig('bearer_token', \Genesis\Config::getBillingApiToken());
    }

    /**
     * Additional optional filter arguments
     *
     * @return string
     */
    protected function getAdditionalArguments()
    {
        return sprintf(
            '%s %s',
            $this->getRequestOrder(),
            $this->getRequestPaging()
        );
    }

    /**
     * Add paging information to the request
     *
     * @return string
     */
    protected function getAdditionalData()
    {
        return $this->pagingGraphQlFields();
    }

    /**
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'response_fields'
        ];
        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldsGroups = [
            'filter' => [
                'start_date',
                'end_date',
                'unique_id',
                'billing_statement_id'
            ]
        ];
        $this->requiredFieldsGroups = \Genesis\Utils\Common::createArrayObject($requiredFieldsGroups);
    }

    /**
     * @return void
     * @throws ErrorParameter
     * @throws InvalidArgument
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateConditionallyRequiredDates();
        $this->validateStatementsMaxCount();
    }

    /**
     * Validate dates
     * If startDate is provided, then endDate should also be provided and vice versa.
     *
     * @return void
     * @throws ErrorParameter
     */
    protected function validateConditionallyRequiredDates()
    {
        if (
            (!empty($this->start_date) && empty($this->end_date))
            || (!empty($this->end_date) && empty($this->start_date))
        ) {
            throw new ErrorParameter(
                'If filter startDate is provided, then endDate should also be provided and vice versa.'
            );
        }
    }

    /**
     * Validate max number of billingStatementId elements
     *
     * @return void
     * @throws ErrorParameter
     */
    protected function validateStatementsMaxCount()
    {
        if (
            !empty($this->billing_statement_id)
            && count($this->billing_statement_id) > self::MAX_COUNT_BILLING_STATEMENTS_FILTER
        ) {
            throw new ErrorParameter(
                sprintf(
                    'Max number of billingStatementID elements allowed is %s.',
                    self::MAX_COUNT_BILLING_STATEMENTS_FILTER
                )
            );
        }
    }

    /**
     * Return a formatted string with request filters
     *
     * @return string
     */
    protected function getRequestFilters()
    {
        $filters = [
            'uniqueId'           => $this->getUniqueId(),
            'startDate'          => $this->getStartDate(),
            'endDate'            => $this->getEndDate(),
            'billingStatementId' => $this->getBillingStatementId()
        ];

        $filters = array_filter($filters);

        $filterData = implode(
            ', ',
            array_map(
                function ($key, $value) {
                    $format = ($key == 'billingStatementId') ? '%s: %s' : '%s: "%s"';

                    return sprintf($format, $key, $value);
                },
                array_keys($filters),
                $filters
            )
        );

        return sprintf(
            'filter: { %s } %s',
            $filterData,
            $this->getAdditionalArguments()
        );
    }

    /**
     * Return a formatted string with paging parameters
     *
     * @return string
     */
    protected function getRequestPaging()
    {
        $paging = [
            'page'    => $this->getPage(),
            'perPage' => $this->getPerPage()
        ];

        return $this->generateGraphQLCode($paging, 'paging');
    }

    /**
     * Return a formatted string with ordering parameters
     *
     * @return string
     */
    protected function getRequestOrder()
    {
        $elements = [
            'byDirection' => $this->getOrderByDirection(),
            'byField'     => $this->getOrderByField()
        ];

        return $this->generateGraphQLCode($elements, 'sort');
    }

    protected function getRequestStructure()
    {
        return $this->getResponseFields();
    }
}

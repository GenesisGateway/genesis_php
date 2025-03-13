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

namespace Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Api\Request\Base\GraphqlRequest;
use Genesis\Api\Traits\Request\NonFinancial\BillingApi\OrderByDirection;
use Genesis\Api\Traits\Request\NonFinancial\DateAttributes;
use Genesis\Api\Traits\Request\NonFinancial\PagingAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidClassMethod;

/**
 * Class Transaction
 *
 * Billing Transactions API request
 * @package Genesis\Api\Request\NonFinancial\BillingApi
 *
 * @method string getOrderByField()
 * @method string getTransactionType()
 */
class Transaction extends GraphqlRequest
{
    use DateAttributes;
    use OrderByDirection;
    use PagingAttributes;

    const MAX_COUNT_BILLING_STATEMENT       = 10;
    const MAX_COUNT_UNIQUE_ID               = 10000;
    const MAX_COUNT_MERCHANT_TRANSACTION_ID = 10000;
    const MAX_COUNT_MASTER_ACCOUNT_NAME     = 10;
    const MAX_DAYS_DIFFERENCE               = 7;

    /**
     * Request filter parameter:
     * List of billing transaction unique IDs. Max number of elements is 10000.
     *
     * @var string[]
     */
    protected $unique_id;

    /**
     * Request filter parameter:
     * List of billing statement IDs. Max number of elements allowed is 10.
     *
     * @var string[]
     */
    protected $billing_statement = [];

    /**
     * Request filter parameter:
     * List of merchant transaction IDs. Max number of elements allowed is 10000.
     *
     * @var string[]
     */
    protected $merchant_transaction_id = [];

    /**
     * Request filter parameter:
     * List of master account names. Max number of elements allowed is 100.
     *
     * @var string[]
     */
    protected $master_account_name = [];

    /**
     * Request filter parameter:
     * Transaction type. See available transaction types. To be passed with spaces and capital letters if any.
     *
     * @var string
     */
    protected $transaction_type;

    /**
     * Field result collection is sorted by.
     * Default value: transactionDate
     *
     * @var string
     */
    protected $order_by_field;

    /**
     * Defines fields that must not be surrounded with quotes in the request
     *
     * @var string[]
     */
    private $filters_without_quotes = ['billingStatement', 'uniqueId', 'merchantTransactionId', 'masterAccountName'];

    public function __construct()
    {
        parent::__construct('billing_transactions', 'billingTransactions');
    }

    /**
     * Set the list of unique IDs in the filter
     *
     * @param array $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setUniqueId($value)
    {
        return $this->parseArrayOfStrings('unique_id', $value, 'UniqueId');
    }

    /**
     * Return a formatted string with the Unique IDs
     *
     * @return string
     */
    public function getUniqueId()
    {
        if (empty($this->unique_id)) {
            return '';
        }

        return sprintf('["%s"]', implode('","', $this->unique_id));
    }

    /**
     * Set the list of Billing statement IDs in the filter
     *
     * @param array $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setBillingStatement($value)
    {
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
     * Set the list of Merchant transaction IDs in the filter
     *
     * @param array $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setMerchantTransactionId($value)
    {
        return $this
            ->parseArrayOfStrings('merchant_transaction_id', $value, 'MerchantTransactionId');
    }

    /**
     * Return a formatted string with the Merchant IDs
     *
     * @return string
     */
    public function getMerchantTransactionId()
    {
        if (empty($this->merchant_transaction_id)) {
            return '';
        }

        return sprintf('["%s"]', implode('","', $this->merchant_transaction_id));
    }

    /**
     * Set the list of Master Account Names in the filter
     *
     * @param array $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setMasterAccountName($value)
    {
        return $this->parseArrayOfStrings('master_account_name', $value, 'MasterAccountName');
    }

    /**
     * Return a formatted string with the Master Account Names
     *
     * @return string
     */
    public function getMasterAccountName()
    {
        if (empty($this->master_account_name)) {
            return '';
        }

        return sprintf('["%s"]', implode('","', $this->master_account_name));
    }

    /**
     * Set transaction type parameter
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setTransactionType($value)
    {
        return $this->allowedOptionsSetter(
            'transaction_type',
            $this->getTransactionTypeAllowedValues(),
            $value,
            'Invalid value given for transactionType. Allowed values: ' .
            implode(', ', $this->getTransactionTypeAllowedValues())
        );
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
                'billing_statement',
                'merchant_transaction_id',
                'master_account_name',
                'transaction_type'
            ]
        ];
        $this->requiredFieldsGroups = \Genesis\Utils\Common::createArrayObject($requiredFieldsGroups);
    }

    /**
     * @return void
     * @throws ErrorParameter
     * @throws InvalidArgument
     * @throws InvalidClassMethod
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateGroupDateRequirements();
        $this->validateDatesMaxDifference(self::MAX_DAYS_DIFFERENCE);
        $this->validateStatementsMaxCount();
    }

    /**
     * Validate max number of filter elements
     *
     * @return void
     * @throws ErrorParameter
     */
    protected function validateStatementsMaxCount()
    {
        $this->checkArrayMaxSize(
            $this->billing_statement,
            self::MAX_COUNT_BILLING_STATEMENT,
            'billingStatement'
        );

        $this->checkArrayMaxSize(
            $this->unique_id,
            self::MAX_COUNT_UNIQUE_ID,
            'uniqueId'
        );

        $this->checkArrayMaxSize(
            $this->merchant_transaction_id,
            self::MAX_COUNT_MERCHANT_TRANSACTION_ID,
            'merchantTransactionId'
        );

        $this->checkArrayMaxSize(
            $this->master_account_name,
            self::MAX_COUNT_MASTER_ACCOUNT_NAME,
            'masterAccountName'
        );
    }

    /**
     * Validate max number of elements in array
     *
     * @param array  $var     - the array variable
     * @param int    $maxSize - max size of the array
     * @param string $message - text for the error message
     *
     * @return void
     * @throws ErrorParameter
     */
    protected function checkArrayMaxSize($var, $maxSize, $message)
    {
        if (!empty($var) && count($var) > $maxSize) {
            throw new ErrorParameter(
                sprintf(
                    'Max number of %s elements allowed is %s.',
                    $message,
                    $maxSize
                )
            );
        }
    }

    /**
     * List of allowed response fields
     *
     * @return string[]
     */
    protected function getResponseFieldsAllowedValues()
    {
        return ['id', 'uniqueId', 'billingStatement', 'arn', 'transactionType', 'transactionDate',
            'transactionCurrency', 'transactionAmount', 'exchangeRate', 'billingCurrency', 'billingAmount',
            'transactionFeeCurrency', 'transactionFeeAmount', 'transactionFeeChargedOnBillingStatement',
            'commissionPercent', 'commissionAmount', 'interchangeFee', 'interchangeCurrency', 'isInterchangeplusplus',
            'interchangeplusplusChargedOnBillingStatement', 'schemeFee', 'schemeFeeCurrency', 'standardDebitCardRate',
            'gstAmount', 'gstRate', 'vatAmount', 'vatRate', 'terminalName', 'region', 'settlementBillingStatements',
            'settlementDates', 'settlementStatus', 'merchantId', 'merchantName', 'merchantTransactionId',
            'masterAccountName', 'valueDate', 'documentId', 'referenceId', 'authCode', 'paymentType', 'cardBrand',
            'cardNumber', 'cardHolder', 'cardType', 'cardSubtype'];
    }

    /**
     * List of allowed fields for response sorting
     *
     * @return string[]
     */
    protected function getOrderByFieldAllowedValues()
    {
        return ['billingStatement', 'transactionDate', 'transactionCurrency', 'transactionAmount', 'exchangeRate',
            'billingAmount', 'transactionFeeAmount', 'commissionPercent', 'commissionAmount', 'interchangeFee',
            'region', 'settlementStatus'];
    }

    /**
     * List of allowed values for transaction_type parameter
     *
     * @return string[]
     */
    protected function getTransactionTypeAllowedValues()
    {
        return ['Authorisation Approved', 'Authorisation Declined', 'Settlement Approved', 'Settlement Declined',
            'Sale Approved', 'Sale Declined', 'Refund Approved', 'Refund Declined', 'Payout Approved',
            'Payout Declined', 'CFT Other Approved', 'CFT Declined', 'Chargeback', 'Chargeback Reversal',
            'Chargeback Representment', 'Retrieval Request', 'Void', 'Visa EU Intraregional Fraud Chargeback',
            'MasterCard EU Region Chargeback', 'Second Chargeback', 'CFT Visa Approved', 'CFT MasterCard Approved',
            'Visa RDR', 'RDR Reversal', 'Gateway Transaction Fee', 'Risk Management Transaction Fee',
            'Fraud Engine Transaction Fee'];
    }

    /**
     * Return a formatted string with request filters
     *
     * @return string
     */
    protected function getRequestFilters()
    {
        $filters = [
            'uniqueId'              => $this->getUniqueId(),
            'startDate'             => $this->getStartDate(),
            'endDate'               => $this->getEndDate(),
            'billingStatement'      => $this->getBillingStatement(),
            'merchantTransactionId' => $this->getMerchantTransactionId(),
            'masterAccountName'     => $this->getMasterAccountName(),
            'transactionType'       => $this->getTransactionType()
        ];

        $filters = array_filter($filters);

        $filterData = implode(
            ', ',
            array_map(
                function ($key, $value) {
                    $format = in_array($key, $this->filters_without_quotes) ? '%s: %s' : '%s: "%s"';

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

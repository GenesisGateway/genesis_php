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

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Constants\NonFinancial\BillingApi\StatementStatuses;
use Genesis\Api\Traits\Request\NonFinancial\DateTimeFromToAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency;

/**
 * Class AbstractStatement
 *
 * Shared base for the billing statement requests (standard Statement and EnhancedStatement).
 * Both map to the same `billing_statements` endpoint and accept the same filter set; only the
 * query name and the response selection tree differ. The date range attributes come from the
 * DateTimeFromToAttributes trait (included here, so their validation lives here as well).
 *
 * @package Genesis\Api\Request\Base\NonFinancial\BillingApi
 *
 * @method string getOrderByField()
 */
abstract class AbstractStatement extends BaseRequest
{
    use DateTimeFromToAttributes;

    const MAX_COUNT_BILLING_STATEMENT = 1000;

    /**
     * Currency code in ISO 4217 format (3 letters).
     *
     * @var string
     */
    protected $currency;

    /**
     * Billing statement status.
     *
     * @var string
     */
    protected $status;

    /**
     * Payment method used. To be passed with spaces and capital letters if any.
     *
     * @var string
     */
    protected $payment_method;

    /**
     * Creation date of the billing statement in UTC.
     *
     * @var \DateTime
     */
    protected $creation_date;

    /**
     * Cursor for the next page of results (value of either after or before cursors from response).
     *
     * @var string
     */
    protected $next;

    /**
     * Set currency with validation
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCurrency($value)
    {
        return $this->allowedOptionsSetter(
            'currency',
            Currency::getList(),
            $value,
            'Invalid value given for currency parameter.'
        );
    }

    /**
     * Set status with validation
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setStatus($value)
    {
        return $this->allowedOptionsSetter(
            'status',
            $this->getStatusAllowedValues(),
            $value,
            'Invalid value given for status. Allowed values: ' .
            implode(', ', $this->getStatusAllowedValues())
        );
    }

    /**
     * Set and format Creation date
     *
     * @param string $date
     * @return $this
     * @throws InvalidArgument
     */
    public function setCreationDate($date)
    {
        if (empty($date)) {
            $this->creation_date = null;

            return $this;
        }

        return $this->parseDate(
            'creation_date',
            DateTimeFormat::getAll(),
            $date,
            'Invalid value given for Creation date.'
        );
    }

    /**
     * Get formatted Creation date
     *
     * @return string|null
     */
    public function getCreationDate()
    {
        return (empty($this->creation_date)) ?
            null : $this->creation_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set cursor for next page
     *
     * @param string $value
     * @return $this
     */
    public function setNext($value)
    {
        $this->next = $value;

        return $this;
    }

    /**
     * Get cursor for next page
     *
     * @return string|null
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Get allowed status values (shared by all statement requests)
     *
     * @return array
     */
    protected function getStatusAllowedValues()
    {
        return StatementStatuses::getAll();
    }

    /**
     * Get allowed order by field values (defined per concrete statement request)
     *
     * @return array
     */
    abstract protected function getOrderByFieldAllowedValues();

    /**
     * Get the request filter map (defined per concrete statement request):
     * GraphQL filter name => rendered value.
     *
     * @return array
     */
    abstract protected function getRequestFilterValues();

    /**
     * Set the required fields for the request
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = ['response_fields'];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldsGroups = [
            'filter' => [
                'start_date_from',
                'start_date_to',
                'end_date_from',
                'end_date_to',
                'billing_statement',
                'currency',
                'status',
                'payment_method',
                'creation_date'
            ]
        ];
        $this->requiredFieldsGroups = CommonUtils::createArrayObject($requiredFieldsGroups);
    }

    /**
     * Validate the request requirements
     *
     * @return void
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();
        $this->validateFromToDateRanges(self::MAX_DAYS_DIFFERENCE);
        $this->validateStatementsMaxCount();
    }

    /**
     * Validate the maximum count of the list filters
     *
     * @return void
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function validateStatementsMaxCount()
    {
        $this->checkArrayMaxSize(
            $this->billing_statement,
            self::MAX_COUNT_BILLING_STATEMENT,
            'billingStatement'
        );

        $this->checkArrayMaxSize(
            $this->master_account_mid,
            self::MAX_COUNT_MASTER_ACCOUNT_MID,
            'masterAccountMID'
        );
    }

    /**
     * Validate the from/to date pairs: each pair must be set together, in order, and span
     * no more than $maxDaysDifference days. Relational (request-level) validation; lives here
     * because this class includes the DateTimeFromToAttributes trait that owns the properties.
     *
     * @param int $maxDaysDifference
     *
     * @return void
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function validateFromToDateRanges($maxDaysDifference)
    {
        $this->validateFromToPair(
            $this->start_date_from,
            $this->start_date_to,
            ['from' => 'startDateFrom', 'to' => 'startDateTo'],
            $maxDaysDifference
        );
        $this->validateFromToPair(
            $this->end_date_from,
            $this->end_date_to,
            ['from' => 'endDateFrom', 'to' => 'endDateTo'],
            $maxDaysDifference
        );
    }

    /**
     * Validate a single from/to pair.
     *
     * @param \DateTime|null $dateFrom
     * @param \DateTime|null $dateTo
     * @param array          $labels keyed 'from' and 'to' with the GraphQL filter names
     * @param int            $maxDaysDifference
     *
     * @return void
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    private function validateFromToPair($dateFrom, $dateTo, array $labels, $maxDaysDifference)
    {
        $fromLabel = $labels['from'];
        $toLabel   = $labels['to'];

        if ((!empty($dateFrom) && empty($dateTo)) || (!empty($dateTo) && empty($dateFrom))) {
            throw new ErrorParameter(
                sprintf(
                    'If filter %s is provided, then %s should also be provided and vice versa.',
                    $fromLabel,
                    $toLabel
                )
            );
        }

        if (empty($dateFrom) || empty($dateTo)) {
            return;
        }

        if ($dateFrom > $dateTo) {
            throw new ErrorParameter(
                sprintf('Filter %s must be before or equal to %s.', $fromLabel, $toLabel)
            );
        }

        if ($dateFrom->diff($dateTo)->days > $maxDaysDifference) {
            throw new ErrorParameter(
                sprintf('Max difference between %s and %s is %s days', $fromLabel, $toLabel, $maxDaysDifference)
            );
        }
    }

    /**
     * Fields that must not be surrounded with quotes in the request (defined per concrete request).
     *
     * @return string[]
     */
    abstract protected function getFiltersWithoutQuotes();

    /**
     * Generate the request filters part of the GraphQL query. The filter map and the
     * unquoted-field list are defined per concrete request; the formatting is shared.
     *
     * @return string
     */
    protected function getRequestFilters()
    {
        $filters           = array_filter($this->getRequestFilterValues());
        $withoutQuotes     = $this->getFiltersWithoutQuotes();

        $filterData = implode(
            ', ',
            array_map(
                function ($key, $value) use ($withoutQuotes) {
                    $format = in_array($key, $withoutQuotes, true) ? '%s: %s' : '%s: "%s"';

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
     * Generate the request paging part of the GraphQL query (cursor-based pagination)
     *
     * @return string
     */
    protected function getRequestPaging()
    {
        $paging = [];

        if ($this->getPerPage()) {
            $paging['perPage'] = $this->getPerPage();
        }

        if ($this->getNext()) {
            $paging['next'] = '"' . $this->escapeGraphQLString($this->getNext()) . '"';
        }

        return $this->generateGraphQLCode($paging, 'paging');
    }

    /**
     * Generate additional data to be requested in the GraphQL query
     *
     * @return string
     */
    protected function getAdditionalData()
    {
        return 'paging {
                    count
                    perPage
                    after
                    before
                }';
    }

    /**
     * Get the request structure fields
     *
     * @return string
     */
    protected function getRequestStructure()
    {
        return $this->getResponseFields();
    }
}

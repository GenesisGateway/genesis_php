<?php

namespace Genesis\Api\Request\NonFinancial\BillingApi;

use DateTime;
use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Request\Base\NonFinancial\BillingApi\BaseRequest;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidClassMethod;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency;

/**
 * Class Statement
 *
 * Billing Statements API request
 * @package Genesis\Api\Request\NonFinancial\BillingApi
 *
 * @method string getOrderByField()
 */
class Statement extends BaseRequest
{
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
     * @var DateTime
     */
    protected $creation_date;

    /**
     * Cursor for the next page of results. It can be value of either after or before cursors from response.
     *
     * @var string
     */
    protected $next;

    /**
     * Defines fields that must not be surrounded with quotes in the request
     *
     * @var string[]
     */
    private $filters_without_quotes = ['billingStatement', 'status'];

    /**
     * Statement constructor.
     */
    public function __construct()
    {
        parent::__construct('billing_statements', 'billingStatements');
    }

    /**
     * Set currency with validation
     *
     * @param string $value
     *
     * @return $this
     *
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
     *
     * @return $this
     *
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
     *
     * @return $this
     *
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
     *
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
     * Return a formatted string with response fields
     *
     * @return string
     */
    public function getResponseFields()
    {
        $fields = [];
        foreach ($this->response_fields as $field) {
            $fields[] = $this->formatComplexField($field);
        }

        return implode(' ', $fields);
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
     * Get allowed status values from GraphQL schema
     *
     * @return array
     */
    protected function getStatusAllowedValues()
    {
        return [
            'open',
            'pending',
            'paid',
            'bounced'
        ];
    }

    /**
     * Get allowed response fields
     *
     * @return array
     */
    protected function getResponseFieldsAllowedValues()
    {
        return [
            'id',
            'billingStatement',
            'status',
            'company',
            'masterAccountName',
            'masterAccountCurrency',
            'valueDate',
            'creationDate',
            'currency',
            'paymentMethod',
            'startDate',
            'endDate',
            'summary',
            'details'
        ];
    }

    /**
     * Get allowed order by field values
     *
     * @return array
     */
    protected function getOrderByFieldAllowedValues()
    {
        return [
            'billingStatement',
            'creationDate',
            'startDate',
            'endDate',
            'valueDate',
            'currency',
            'status',
            'masterAccountName'
        ];
    }

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
                'start_date',
                'end_date',
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
     *
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
     * Validate the maximum count of billing statements
     *
     * @return void
     *
     * @throws ErrorParameter
     */
    protected function validateStatementsMaxCount()
    {
        $this->checkArrayMaxSize(
            $this->billing_statement,
            self::MAX_COUNT_BILLING_STATEMENT,
            'billingStatement'
        );
    }

    /**
     * Generate the request filters part of the GraphQL query
     *
     * @return string
     */
    protected function getRequestFilters()
    {
        $filters = [
            'startDate'        => $this->getStartDate(),
            'endDate'          => $this->getEndDate(),
            'billingStatement' => $this->getBillingStatement(),
            'currency'         => $this->getCurrency(),
            'status'           => $this->getStatus(),
            'paymentMethod'    => $this->getPaymentMethod(),
            'creationDate'     => $this->getCreationDate()
        ];

        $filters = array_filter($filters);

        $filterData = implode(
            ', ',
            array_map(
                function ($key, $value) {
                    $format = in_array($key, $this->filters_without_quotes, true) ? '%s: %s' : '%s: "%s"';

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
     * Generate the request paging part of the GraphQL query (overridden for cursor-based pagination)
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
            $paging['next'] = '"' . $this->getNext() . '"';
        }

        return $this->generateGraphQLCode($paging, 'paging');
    }

    /**
     * Format complex GraphQL fields
     *
     * @param string $field
     *
     * @return string
     */
    protected function formatComplexField($field)
    {
        switch ($field) {
            case 'summary':
                return 'summary { grossVolume debit credit fees taxes netReserves adjustments netSettlementAmount ' .
                    'paymentFxConversionFee paymentAmount paymentCurrency }';
            case 'details':
                return 'details { transactionTypesBreakdown { category transactionType count amount } }';
            default:
                return $field;
        }
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

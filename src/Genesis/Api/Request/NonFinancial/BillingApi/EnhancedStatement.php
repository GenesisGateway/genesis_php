<?php

namespace Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Api\Request\Base\NonFinancial\BillingApi\AbstractStatement;

/**
 * Class EnhancedStatement
 *
 * Enhanced Billing Statements API request (enhancedBillingStatements query).
 * Shares the standard statement filters and cursor paging; differs only in the query name
 * and the set of selectable response fields. The caller provides the response structure
 * (flat and/or nested); the base renders it.
 *
 * @package Genesis\Api\Request\NonFinancial\BillingApi
 *
 * @method string getOrderByField()
 */
class EnhancedStatement extends AbstractStatement
{
    /**
     * EnhancedStatement constructor.
     */
    public function __construct()
    {
        parent::__construct('billing_statements', 'enhancedBillingStatements');
    }

    /**
     * Get allowed top-level response fields
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
            'masterAccountMID',
            'masterAccountCurrency',
            'valueDate',
            'creationDate',
            'currency',
            'paymentMethod',
            'startDate',
            'endDate',
            'pricingMethod',
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
     * Request filter map: GraphQL filter name => rendered value.
     *
     * @return array
     */
    protected function getRequestFilterValues()
    {
        return [
            'startDateFrom'    => $this->getStartDateFrom(),
            'startDateTo'      => $this->getStartDateTo(),
            'endDateFrom'      => $this->getEndDateFrom(),
            'endDateTo'        => $this->getEndDateTo(),
            'billingStatement' => $this->getBillingStatement(),
            'masterAccountMID' => $this->getMasterAccountMID(),
            'currency'         => $this->getCurrency(),
            'status'           => $this->getStatus(),
            'paymentMethod'    => $this->getPaymentMethod(),
            'creationDate'     => $this->getCreationDate()
        ];
    }

    /**
     * Fields rendered without surrounding quotes.
     *
     * @return string[]
     */
    protected function getFiltersWithoutQuotes()
    {
        return ['billingStatement', 'status', 'masterAccountMID'];
    }
}

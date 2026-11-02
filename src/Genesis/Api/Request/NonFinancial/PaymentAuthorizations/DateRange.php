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

namespace Genesis\Api\Request\NonFinancial\PaymentAuthorizations;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Request\Base\NonFinancial\DateRangeRequest as BaseDateRangeRequest;
use Genesis\Api\Traits\Request\NonFinancial\Scope;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Common;

/**
 * Class DateRange
 *
 * Payment Authorizations request by date range. Retrieves the payment authorizations
 * that fall within a start and end date range.
 *
 * @package Genesis\Api\Request\NonFinancial\PaymentAuthorizations
 *
 * @method int    getPage() The page within the paginated result
 * @method int    getPerPage() Number of entities per page
 */
class DateRange extends BaseDateRangeRequest
{
    use Scope;

    const MAX_PER_PAGE = 500;

    /**
     * Start of the requested auth date range
     *
     * @var \DateTime $auth_start_date
     */
    protected $auth_start_date;

    /**
     * End of the requested auth date range
     *
     * @var \DateTime $auth_end_date
     */
    protected $auth_end_date;

    /**
     * Start of the requested auth date range
     *
     * @param mixed $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setAuthStartDate($value)
    {
        if (empty($value)) {
            $this->auth_start_date = null;

            return $this;
        }

        return $this->parseDate(
            'auth_start_date',
            DateTimeFormat::getAll(),
            (string)$value,
            'Invalid format for auth_start_date'
        );
    }

    /**
     * End of the requested auth date range
     *
     * @param mixed $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setAuthEndDate($value)
    {
        if (empty($value)) {
            $this->auth_end_date = null;

            return $this;
        }

        return $this->parseDate(
            'auth_end_date',
            DateTimeFormat::getAll(),
            (string)$value,
            'Invalid format for auth_end_date'
        );
    }

    /**
     * Get formatted Auth Start Date as string
     *
     * @return string|null
     */
    public function getAuthStartDate()
    {
        return empty($this->auth_start_date) ?
            null : $this->auth_start_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Get formatted Auth End Date as string
     *
     * @return string|null
     */
    public function getAuthEndDate()
    {
        return empty($this->auth_end_date) ?
            null : $this->auth_end_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    protected function initConfiguration()
    {
        parent::initBaseConfiguration('payment_authorizations/by_date');
    }

    /**
     * Set the required fields
     *
     * scope is always required; one of start_date or auth_start_date must be set
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $this->requiredFields = Common::createArrayObject(['scope']);

        $this->requiredFieldsGroups = Common::createArrayObject([
            'dates' => ['start_date', 'auth_start_date']
        ]);
    }

    /**
     * Validates both the creation and the auth date ranges
     *
     * The auth range is compared by calendar day only, since the gateway receives yyyy-mm-dd
     *
     * @throws ErrorParameter
     */
    protected function validateDateRange()
    {
        parent::validateDateRange();

        if (
            $this->auth_start_date instanceof \DateTime &&
            $this->auth_end_date instanceof \DateTime &&
            $this->getAuthStartDate() > $this->getAuthEndDate()
        ) {
            throw new ErrorParameter('Auth end date must be greater than or equal to the auth start date');
        }
    }

    /**
     * Validates the request requirements and the per_page upper bound
     *
     * @throws ErrorParameter
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validatePerPage();
    }

    protected function getRequestStructure()
    {
        return array_merge(
            [
                'auth_start_date' => $this->getAuthStartDate(),
                'auth_end_date'   => $this->getAuthEndDate()
            ],
            $this->getScopeStructure()
        );
    }

    protected function getParentNode()
    {
        return 'payment_authorization_request';
    }

    /**
     * Ensures the requested per_page does not exceed the allowed maximum
     *
     * @throws ErrorParameter
     */
    private function validatePerPage()
    {
        if ($this->per_page > self::MAX_PER_PAGE) {
            throw new ErrorParameter(
                sprintf('Invalid value for per_page: maximum allowed is %d.', self::MAX_PER_PAGE)
            );
        }
    }
}

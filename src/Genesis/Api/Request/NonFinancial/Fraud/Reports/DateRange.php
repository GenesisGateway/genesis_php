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

namespace Genesis\Api\Request\NonFinancial\Fraud\Reports;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Traits\Request\NonFinancial\PagingAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Common as CommonUtils;

/**
 * Fraud (SAFE/TC40) reports by Date Range
 *
 * @package    Genesis
 * @subpackage Request
 */
class DateRange extends \Genesis\Api\Request
{
    use PagingAttributes;

    /**
     * start of the requested date range
     *
     * @var \DateTime
     */
    protected $start_date;

    /**
     * end of the requested date range
     *
     * @var \DateTime
     */
    protected $end_date;

    /**
     * Date of import in the system. Spans from the beginning until the end of the day
     *
     * @var \DateTime
     */
    protected $import_date;

    /**
     * Start of the requested date range for the date when the fraud was reported
     *
     * @var \DateTime
     */
    protected $report_start_date;

    /**
     * End of the requested date range for the date when the fraud was reported
     *
     * @var \DateTime
     */
    protected $report_end_date;

    /**
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setStartDate($value)
    {
        if (empty($value)) {
            $this->start_date = null;

            return $this;
        }

        return $this->parseDate(
            'start_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid format for start_date'
        );
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setEndDate($value)
    {
        if (empty($value)) {
            $this->end_date = null;

            return $this;
        }

        return $this->parseDate(
            'end_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid format for end_date'
        );
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setImportDate($value)
    {
        if (empty($value)) {
            $this->import_date = null;

            return $this;
        }

        return $this->parseDate(
            'import_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid format for import_date'
        );
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setReportStartDate($value)
    {
        if (empty($value)) {
            $this->report_start_date = null;

            return $this;
        }

        return $this->parseDate(
            'report_start_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid format for report_start_date'
        );
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setReportEndDate($value)
    {
        if (empty($value)) {
            $this->report_end_date = null;

            return $this;
        }

        return $this->parseDate(
            'report_end_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid format for report_end_date'
        );
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return (empty($this->start_date)) ? null :
            $this->start_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return (empty($this->end_date)) ? null :
            $this->end_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @return string
     */
    public function getImportDate()
    {
        return (empty($this->import_date)) ? null :
            $this->import_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @return string
     */
    public function getReportStartDate()
    {
        return (empty($this->report_start_date)) ? null :
            $this->report_start_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @return string
     */
    public function getReportEndDate()
    {
        return (empty($this->report_end_date)) ? null :
            $this->report_end_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     * @throws EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration('fraud_reports/by_date', false);
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFieldsConditional = [
            'start_date'        => ['end_date'],
            'report_start_date' => ['report_end_date']
        ];
        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
    }

    /**
     * @throws ErrorParameter
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateConditionallyRequiredDates();
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'fraud_report_request' => [
                'start_date'        => $this->getStartDate(),
                'end_date'          => $this->getEndDate(),
                'import_date'       => $this->getImportDate(),
                'report_start_date' => $this->getReportStartDate(),
                'report_end_date'   => $this->getReportEndDate(),
                'page'              => $this->page,
                'per_page'          => $this->per_page
            ]
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }

    /**
     * Validate date parameters
     * Only one date type should be used in the request
     *
     * @throws ErrorParameter
     */
    private function validateConditionallyRequiredDates()
    {
        $params = [$this->getStartDate(), $this->getImportDate(), $this->getReportStartDate()];

        if (count(array_filter($params)) != 1) {
            throw new ErrorParameter(
                'Either start_date/end_date, import_date or report_start_date/report_end_date' .
                    ' fields have to be set, do not mix'
            );
        }
    }
}

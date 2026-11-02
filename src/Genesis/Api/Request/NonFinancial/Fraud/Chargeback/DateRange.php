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

namespace Genesis\Api\Request\NonFinancial\Fraud\Chargeback;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Traits\Request\NonFinancial\DateAttributes;
use Genesis\Api\Traits\Request\NonFinancial\PagingAttributes;
use Genesis\Api\Traits\Request\NonFinancial\Scope;
use Genesis\Exceptions\ErrorParameter;

/**
 * Chargeback request by Date Range
 *
 * @package    Genesis
 * @subpackage Request
 */
class DateRange extends \Genesis\Api\Request
{
    use PagingAttributes;
    use Scope;
    use DateAttributes;

    /**
     * date of import in our system. Spans from beggining until end of day
     *
     * @var \DateTime
     */
    protected $import_date;

    /**
     * @param $value
     * @return DateRange
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
            (string) $value,
            'Invalid format for import_date.'
        );
    }

    /**
     * @return string
     */
    public function getImportDate()
    {
        return empty($this->import_date) ?
            null : $this->import_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration('chargebacks/by_date', false);
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFieldsOR = [
            'start_date',
            'import_date'
        ];

        $this->requiredFieldsOR = \Genesis\Utils\Common::createArrayObject($requiredFieldsOR);

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject([
            'scope'
        ]);
    }

    /**
     * @throws ErrorParameter
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateConditionallyRequiredDates();
        $this->validateDateRange();
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'chargeback_request' => array_merge(
                [
                    'start_date'  => $this->getStartDate(),
                    'end_date'    => $this->getEndDate(),
                    'import_date' => $this->getImportDate(),
                    'page'        => $this->page,
                    'per_page'    => $this->per_page
                ],
                $this->getScopeStructure()
            )
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }

    /**
     * Validates if Date Range is Valid one
     *
     * @throws ErrorParameter
     */
    private function validateDateRange()
    {
        if ($this->end_date instanceof \DateTime && $this->start_date > $this->end_date) {
            throw new ErrorParameter('Invalid date range! Start Date should be smaller than End Date.');
        }
    }

    /**
     * Validate StartDate & ImportDate
     * If two are filled then error
     * Only one field should be in request
     *
     * @throws ErrorParameter
     */
    private function validateConditionallyRequiredDates()
    {
        if (!empty($this->getStartDate()) && !empty($this->getImportDate())) {
            throw new ErrorParameter(
                'Only the start date or the import date should be provided, not both!'
            );
        }
    }
}

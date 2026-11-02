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

namespace Genesis\Api\Request\NonFinancial\Fraud\Rdr;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Request\Base\NonFinancial\DateRangeRequest as BaseDateRangeRequest;
use Genesis\Api\Traits\Request\NonFinancial\Scope;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Common;

/**
 * Rapid Dispute Resolution request by Date Range
 *
 * Uses the current scope parameter contract. The deprecated processing_type / externally_processed
 * filters are intentionally not supported and never emitted.
 *
 * @package    Genesis
 * @subpackage Request
 *
 * @method getScope() Filters rapid dispute resolutions by card present, card not present or externally processed
 */
class DateRange extends BaseDateRangeRequest
{
    use Scope;

    /**
     * date of import in our system. Spans from beginning until end of day
     *
     * @var \DateTime
     */
    protected $import_date;

    /**
     * Filter by RDR import date
     *
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
        parent::initBaseConfiguration('rapid_dispute_resolutions/by_date');
    }

    /**
     * Set the required fields
     *
     * The scope filter is always required. Either start_date or import_date must be
     * provided (validated in checkRequirements), so neither is listed as unconditionally required.
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $this->requiredFields = Common::createArrayObject([
            'scope'
        ]);

        $requiredFieldsOR = [
            'start_date',
            'import_date'
        ];

        $this->requiredFieldsOR = Common::createArrayObject($requiredFieldsOR);
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
     * Get the root node of the Populated XML structure
     *
     * @return string
     */
    protected function getParentNode()
    {
        return 'rapid_dispute_resolution_request';
    }

    /**
     * Get additional attributes
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return array_merge(
            [
                'import_date' => $this->getImportDate()
            ],
            $this->getScopeStructure()
        );
    }

    /**
     * Validate StartDate & ImportDate
     * If both are filled then error
     * Only one field should be in the request
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

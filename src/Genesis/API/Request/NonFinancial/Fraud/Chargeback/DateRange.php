<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\NonFinancial\Fraud\Chargeback;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ExternallyProcessed;
use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ProcessingTypes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\ErrorParameter;

/**
 * Chargeback request by Date Range
 *
 * @package    Genesis
 * @subpackage Request
 *
 * @method getPage() Get the page within the paginated result
 * @method getPerPage() Get number of entities on page
 * @method getExternallyProcessed() Filters chargebacks by being externally processed or being native to Genesis
 * @method getProcessingType() Filters chargebacks by being card present or card not present
 */
class DateRange extends \Genesis\API\Request
{
    use RestrictedSetter;

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
     * date of import in our system. Spans from beggining until end of day
     *
     * @var \DateTime
     */
    protected $import_date;

    /**
     * the page within the paginated result
     *
     * default: 1
     *
     * @var int $page
     */
    protected $page;

    /**
     * Number of entities per page
     *
     * default: 100
     *
     * @var int $per_page
     */
    protected $per_page;

    /**
     * Filters chargebacks by being externally processed or being native to Genesis
     *
     * @var string $externally_processed
     */
    protected $externally_processed;

    /**
     * Filters chargebacks by being card present or card not present
     *
     * @var string $processing_type
     */
    protected $processing_type;

    /**
     * Start of requested date range
     *
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
            (string) $value,
            'Invalid format for start_date.'
        );
    }

    /**
     * End of requested date range
     *
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
            (string) $value,
            'Invalid format for end_date.'
        );
    }

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
     * the within the paginated result
     *
     * @param $value
     * @return $this
     */
    public function setPage($value)
    {
        $this->page = (int) $value;

        return $this;
    }

    /**
     * Number of entities on page, default to 100
     *
     * @param $value
     * @return $this
     */
    public function setPerPage($value)
    {
        $this->per_page = (int) $value;

        return $this;
    }

    /**
     * Filters chargebacks by being externally processed or being native to Genesis.
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setExternallyProcessed($value)
    {
        if ($value === null) {
            $this->externally_processed = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'externally_processed',
            ExternallyProcessed::getAll(),
            $value,
            'Invalid value for externally_processed attribute.'
        );
    }

    /**
     * Filters Chargebacks by being card present or card not present
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setProcessingType($value)
    {
        if ($value === null) {
            $this->processing_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'processing_type',
            ProcessingTypes::getAll(),
            $value,
            'Invalid value for processing_type attribute.'
        );
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return empty($this->start_date) ?
            null : $this->start_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return empty($this->end_date) ?
            null : $this->end_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
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
            'chargeback_request' => [
                'start_date'           => $this->getStartDate(),
                'end_date'             => $this->getEndDate(),
                'import_date'          => $this->getImportDate(),
                'page'                 => $this->page,
                'per_page'             => $this->per_page,
                'externally_processed' => $this->externally_processed,
                'processing_type'      => $this->processing_type
            ]
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

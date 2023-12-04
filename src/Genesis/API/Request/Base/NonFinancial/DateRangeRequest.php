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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Base\NonFinancial;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Request;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Common;

/**
 * Class DateRangeRequest
 * @package Genesis\API\Request\Base\NonFinancial\ProcessedTransactions
 */
abstract class DateRangeRequest extends Request
{
    /**
     * start of the requested date range
     *
     * @var \DateTime $start_date
     */
    protected $start_date;

    /**
     * end of the requested date range
     *
     * @var \DateTime $end_date
     */
    protected $end_date;

    /**
     * the page within the paginated result
     * defaults to 1
     *
     * @var integer $page
     */
    protected $page;

    /**
     * Number of entities on page
     * default to 100
     *
     * @var integer $per_page
     */
    protected $per_page;

    /**
     * Start of requested date range
     *
     * @param $value
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
            (string)$value,
            'Invalid format for start_date'
        );
    }

    /**
     * End of requested date range
     *
     * @param $value
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
            (string)$value,
            'Invalid format for end_date'
        );
    }

    /**
     * the page within the paginated result, defaults to 1
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
     * Get formatted Start Date as string
     *
     * @return string|null
     */
    public function getStartDate()
    {
        return empty($this->start_date) ?
            null : $this->start_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Get formatted
     *
     * @return string|null
     */
    public function getEndDate()
    {
        return empty($this->end_date) ?
            null : $this->end_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'start_date'
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }

    protected function initBaseConfiguration($requestPath)
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration($requestPath, false);
    }

    /**
     * @throws ErrorParameter
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateDateRange();
    }

    protected function populateStructure()
    {
        $treeStructure = [
            $this->getParentNode() => array_merge(
                [
                    'start_date' => $this->getStartDate(),
                    'end_date'   => $this->getEndDate(),
                    'page'       => $this->page,
                    'per_page'   => $this->per_page
                ],
                $this->getRequestStructure()
            )
        ];

        $this->treeStructure = Common::createArrayObject($treeStructure);
    }

    /**
     * Get additional attributes
     *
     * @return array
     */
    abstract protected function getRequestStructure();

    /**
     * Get the root node of the Populated XML structure
     *
     * @return string
     */
    abstract protected function getParentNode();

    /**
     * Validates if Date Range is Valid one
     *
     * @throws ErrorParameter
     */
    protected function validateDateRange()
    {
        if ($this->end_date instanceof \DateTime && $this->start_date > $this->end_date) {
            throw new ErrorParameter('End date must be greater than or equal to the start date');
        }
    }
}

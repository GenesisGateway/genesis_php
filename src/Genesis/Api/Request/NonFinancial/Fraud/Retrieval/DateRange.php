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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\NonFinancial\Fraud\Retrieval;

use Genesis\Api\Constants\DateTimeFormat;

/**
 * Retrieval request by Date Range
 *
 * @package    Genesis
 * @subpackage Request
 */

class DateRange extends \Genesis\Api\Request
{
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
     * the page within the paginated result
     *
     * default: 1
     *
     * @var int
     */
    protected $page;

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
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration('retrieval_requests/by_date', false);
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

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'retrieval_request_request' => [
                'start_date' => $this->getStartDate(),
                'end_date'   => $this->getEndDate(),
                'page'       => $this->page
            ]
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

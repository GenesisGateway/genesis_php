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

namespace Genesis\API\Request\NonFinancial\Reconcile;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\API\Validators\Request\RegexValidator;

/**
 * Reconcile request by Date Range
 *
 * @package    Genesis
 * @subpackage Request
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
     * the page within the paginated result
     *
     * default: 1
     *
     * @var int
     */
    protected $page;

    /**
     * Optional time in start_date
     * @var bool
     */
    private $start_date_has_time = false;

    /**
     * Optional time in end_date
     * @var bool
     */
    private $end_date_has_time = false;

    /**
     * @param string $date
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setStartDate($date)
    {
        if (empty($date)) {
            $this->start_date = null;

            return $this;
        }

        if (preg_match(RegexValidator::PATTERN_TIMESTAMP, $date) === 1) {
            $this->start_date_has_time = true;
        }

        return $this->parseDate(
            'start_date',
            DateTimeFormat::getAll(),
            $date,
            'Invalid value given for Start date.'
        );
    }

    /**
     * @return string|null
     */
    public function getStartDate()
    {
        $format = $this->start_date_has_time ? DateTimeFormat::YYYY_MM_DD_H_I_S :
            DateTimeFormat::YYYY_MM_DD_ISO_8601;

        return (empty($this->start_date)) ? null : $this->start_date->format($format);
    }

    /**
     * @param string $date
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setEndDate($date)
    {
        if (empty($date)) {
            $this->end_date = null;

            return $this;
        }

        if (preg_match(RegexValidator::PATTERN_TIMESTAMP, $date) === 1) {
            $this->end_date_has_time = true;
        }

        return $this->parseDate(
            'end_date',
            DateTimeFormat::getAll(),
            $date,
            'Invalid value given for End date.'
        );
    }

    /**
     * @return string|null
     */
    public function getEndDate()
    {
        $format = $this->end_date_has_time ? DateTimeFormat::YYYY_MM_DD_H_I_S :
            DateTimeFormat::YYYY_MM_DD_ISO_8601;

        return (empty($this->end_date)) ? null : $this->end_date->format($format);
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration('reconcile/by_date');
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
            'reconcile' => [
                'start_date' => $this->getStartDate(),
                'end_date'   => $this->getEndDate(),
                'page'       => $this->page
            ]
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

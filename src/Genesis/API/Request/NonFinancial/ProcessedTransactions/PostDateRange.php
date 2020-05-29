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

namespace Genesis\API\Request\NonFinancial\ProcessedTransactions;

use Genesis\API\Request\Base\NonFinancial\DateRangeRequest as BaseDateRangeRequest;
use Genesis\API\Traits\Request\NonFinancial\ExternallyProcessed;
use Genesis\API\Traits\Request\NonFinancial\ProcessingType;

/**
 * Class PostDateRange
 * @package Genesis\API\Request\NonFinancial\ProcessedTransactions
 */
class PostDateRange extends BaseDateRangeRequest
{
    use ExternallyProcessed, ProcessingType;

    /**
     * Batch number of processed transactions
     *
     * @var string $batch_number
     */
    protected $batch_number;

    /**
     * Batch slip number of processed transactions
     *
     * @var string $batch_slip_number
     */
    protected $batch_slip_number;

    /**
     * Deposit slip number of processed transactions
     *
     * @var string $deposit_slip_number
     */
    protected $deposit_slip_number;

    /**
     * Batch number of processed transactions
     *
     * @param $value
     * @return $this
     */
    public function setBatchNumber($value)
    {
        $this->batch_number = (string) $value;

        return $this;
    }

    /**
     * Batch slip number of processed transactions
     *
     * @param $value
     * @return $this
     */
    public function setBatchSlipNumber($value)
    {
        $this->batch_slip_number = (string) $value;

        return $this;
    }

    /**
     * Deposit slip number of processed transactions
     *
     * @param $value
     * @return $this
     */
    public function setDepositSlipNumber($value)
    {
        $this->deposit_slip_number = (string) $value;

        return $this;
    }

    protected function initConfiguration()
    {
        parent::initBaseConfiguration('processed_transactions/by_post_date');
    }

    protected function getRequestStructure()
    {
        return array_merge(
            [
                'batch_number'        => $this->batch_number,
                'batch_slip_number'   => $this->batch_slip_number,
                'deposit_slip_number' => $this->deposit_slip_number
            ],
            $this->getExternallyProcessedStructure(),
            $this->getProcessingTypeStructure()
        );
    }

    protected function getParentNode()
    {
        return 'processed_transaction_request';
    }
}

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

namespace Genesis\Api\Request\NonFinancial\ProcessedBatches;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request\Base\NonFinancial\DateRangeRequest as BaseDateRangeRequest;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\InvalidArgument;

/**
 * Class PostDateRange
 * @package Genesis\Api\Request\NonFinancial\ProcessedBatches
 *
 * @method string getBatchSlipNumber()
 */
class PostDateRange extends BaseDateRangeRequest
{
    /**
     * Batch slip number of processed transactions
     *
     * @var string $batch_slip_number
     */
    protected $batch_slip_number;

    /**
     * @param string $builderInterface
     * @throws InvalidArgument
     */
    public function __construct($builderInterface = Builder::XML)
    {
        parent::__construct($builderInterface);

        if (Config::getEndpoint() == Endpoints::EMERCHANTPAY) {
            throw new InvalidArgument(
                'Unsupported endpoint for this transaction type'
            );
        }
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

    protected function initConfiguration()
    {
        parent::initBaseConfiguration('processed_batches/by_post_date');
    }

    protected function getRequestStructure()
    {
        return [
            'batch_slip_number' => $this->batch_slip_number
        ];
    }

    protected function getParentNode()
    {
        return 'processed_batch_request';
    }
}

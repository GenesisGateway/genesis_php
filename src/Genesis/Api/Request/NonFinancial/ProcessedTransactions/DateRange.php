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

namespace Genesis\Api\Request\NonFinancial\ProcessedTransactions;

use Genesis\Api\Request\Base\NonFinancial\DateRangeRequest as BaseDateRangeRequest;
use Genesis\Api\Traits\Request\NonFinancial\ExternallyProcessed;
use Genesis\Api\Traits\Request\NonFinancial\ProcessingType;

class DateRange extends BaseDateRangeRequest
{
    use ExternallyProcessed;
    use ProcessingType;

    protected function initConfiguration()
    {
        parent::initBaseConfiguration('processed_transactions/by_date');
    }

    protected function getRequestStructure()
    {
        return array_merge(
            $this->getExternallyProcessedStructure(),
            $this->getProcessingTypeStructure()
        );
    }

    protected function getParentNode()
    {
        return 'processed_transaction_request';
    }
}

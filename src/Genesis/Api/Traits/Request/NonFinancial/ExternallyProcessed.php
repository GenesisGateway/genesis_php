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

namespace Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait ExternallyProcessed
 * @package Genesis\Api\Traits\Request\NonFinancial
 */
trait ExternallyProcessed
{
    /**
     * Filters transactions by being extenrally processed or
     * being native to Genesis
     *
     * @var string $externally_processed
     */
    protected $externally_processed;

    /**
     * Filters transactions by being externally processed or being native to Genesis
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setExternallyProcessed($value)
    {
        if ($value === null) {
            $this->externally_processed = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'externally_processed',
            \Genesis\Api\Constants\NonFinancial\Fraud\Chargeback\ExternallyProcessed::getAll(),
            $value,
            'Invalid value for externally_processed attribute.'
        );
    }

    /**
     * Get ExternallyProcessedStructure array
     *
     * @return array
     */
    protected function getExternallyProcessedStructure()
    {
        return [
            'externally_processed' => $this->externally_processed
        ];
    }
}

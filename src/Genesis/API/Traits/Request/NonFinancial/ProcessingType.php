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

namespace Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ProcessingTypes;

/**
 * Trait ProcessingType
 * @package Genesis\API\Traits\Request\NonFinancial
 */
trait ProcessingType
{

    /**
     * Filters transactions by being card present or card not present
     *
     * @var string $processing_type
     */
    protected $processing_type;

    /**
     * Filters transactions by being card present or card not present
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
     * Get ProcessingTypeStructure array
     *
     * @return array
     */
    protected function getProcessingTypeStructure()
    {
        return [
            'processing_type' => $this->processing_type
        ];
    }
}

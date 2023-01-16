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

namespace Genesis\API\Traits\Request;

use Genesis\API\Validators\Request\RegexValidator;

/**
 * Trait DocumentAttributes
 * @package Genesis\API\Traits\Request
 *
 * @method string getDocumentId()
 * @method $this setDocumentId($value)
 */
trait DocumentAttributes
{
    /**
     * @var string
     */
    protected $document_id;

    /**
     * @return array
     */
    protected function getDocumentIdConditions()
    {
        return [
            'billing_country' => [
                'AR' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_AR)]
                ],
                'BR' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_BR)]
                ],
                'CL' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_CL)]
                ],
                'CO' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_CO)]
                ],
                'IN' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_IN)]
                ],
                'MX' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_MX)]
                ],
                'PY' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_PY)]
                ],
                'PE' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_PE)]
                ],
                'TR' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_TR)]
                ],
                'UY' => [
                    ['document_id' => new RegexValidator(RegexValidator::REGEXP_DOCUMENT_ID_UY)]
                ],
            ]
        ];
    }
}

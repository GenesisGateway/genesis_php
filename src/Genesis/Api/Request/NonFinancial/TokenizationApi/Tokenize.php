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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\Base\NonFinancial\TokenizationApi\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\TokenizationApiAttributes;
use Genesis\Api\Traits\Request\NonFinancial\TokenizationApiCardAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Tokenize
 *
 * Tokenizes cardholder data and issues a corresponding token. Merchants should take care to save
 * the plain-text token value in their system as once issued it is not possible to obtain it again.
 * Attempting to tokenize the same cardholder data will issue a new token.
 * The token can be used in the Processing API instead of the cardholder data.
 *
 * @package Genesis\Api\Request\NonFinancial\TokenizationApi
 *
 * @method bool|null getSchemeTokenized()    Whether Card Scheme Tokenization will be used
 * @method $this setSchemeTokenized($value)  Request Card Scheme Tokenization
 */
class Tokenize extends BaseRequest
{
    use TokenizationApiAttributes;
    use TokenizationApiCardAttributes;

    /**
     * Indicates that Card Scheme Tokenization will be used.
     * Sent only when explicitly set; omitted otherwise.
     *
     * @var bool|null
     */
    protected $scheme_tokenized;

    /**
     * Tokenize constructor
     */
    public function __construct()
    {
        parent::__construct('tokenize');
    }

    /**
     * Set whether Card Scheme Tokenization will be used
     *
     * @param bool|string|int $value Boolean or a value recognized as boolean (e.g. 'true', 'no', 1, 0)
     *
     * @return $this
     * @throws InvalidArgument When the value is not recognized as a boolean
     */
    public function setSchemeTokenized($value)
    {
        $filtered = CommonUtils::filterBoolean($value);

        if (!is_bool($filtered)) {
            throw new InvalidArgument('Invalid value given for scheme_tokenized. Boolean value is expected.');
        }

        $this->scheme_tokenized = $filtered;

        return $this;
    }

    /**
     * Return the parameters which may hold empty (but not null) values, e.g. scheme_tokenized = false
     * Example value:
     * array(
     *     'class_property' => 'request_structure_key'
     * )
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return [
            'scheme_tokenized' => 'scheme_tokenized'
        ];
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'consumer_id'      => $this->consumer_id,
            'token_type'       => $this->token_type,
            'email'            => $this->email,
            'card_data'        => $this->getCreditCardParamsStructure(),
            'scheme_tokenized' => $this->scheme_tokenized
        ];
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'consumer_id',
            'token_type',
            'email',
            'card_number'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = $this->getCCNumberValueFormatValidator();

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }
}

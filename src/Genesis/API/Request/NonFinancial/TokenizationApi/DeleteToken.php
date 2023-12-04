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

namespace Genesis\API\Request\NonFinancial\TokenizationApi;

use Genesis\API\Request\Base\NonFinancial\TokenizationApi\BaseRequest;
use Genesis\API\Traits\Request\NonFinancial\TokenizationApiAttributes;
use Genesis\API\Traits\Request\NonFinancial\TokenizationApiTokenAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class DeleteToken
 *
 * Deletes a token.
 *
 * @package Genesis\API\Request\NonFinancial\TokenizationApi
 */
class DeleteToken extends BaseRequest
{
    use TokenizationApiAttributes, TokenizationApiTokenAttributes;

    /**
     * DeleteToken constructor
     */
    public function __construct()
    {
        parent::__construct('delete_token');
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'consumer_id' => $this->consumer_id,
            'email'       => $this->email,
            'token'       => $this->token,
            'token_type'  => $this->token_type
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
            'email',
            'token',
            'token_type'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }
}

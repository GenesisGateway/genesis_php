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

namespace Genesis\API\Request\Base\NonFinancial\TokenizationApi;

use Genesis\API\Request\Base\BaseVersionedRequest;
use Genesis\Builder;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class BaseRequest
 *
 * Tokenization is the process of replacing sensitive cardholder data with a surrogate value ("token").
 * The data to be tokenized must include at least the primary account number (PAN).
 *
 * Tokenization greatly reduces the sensitive data that businesses need to store, thus improving security of
 * credit card transactions and minimizing the costs related to PCI DSS compliance.
 *
 * We issue reversible non-cryptographic tokens to merchants via our Tokenization API and take care to store
 * safely the tokenized cardholder data. Merchants are able to use the issued tokens instead of the cardholder
 * data when creating credit card transactions via our Processing API. PCI DSS compliant merchants have also the
 * possibility to exchange the token for the original cardholder data via our Tokenization API ("detokenization").
 *
 * @package Genesis\API\Request\Base\NonFinancial\Tokenization
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    /**
     * Tokenization constructor.
     *
     * @param string $requestPath
     */
    public function __construct($requestPath)
    {
        parent::__construct($requestPath, Builder::XML, ['v1']);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            $this->getRequestPath() . '_request' => $this->getRequestStructure()
        ];

        $this->treeStructure = CommonUtils::createArrayObject($treeStructure);
    }
}

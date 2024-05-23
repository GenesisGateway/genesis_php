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

namespace Genesis\Api\Request\NonFinancial\Kyc\IdentityDocument;

use Genesis\Api\Constants\NonFinancial\Kyc\IdentityDocumentMethods;
use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\IdentityDocuments;

/**
 * Class Upload
 *
 * Used to verify documents provided by the customer.
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\IdentityDocument
 */
class Upload extends BaseRequest
{
    use IdentityDocuments;

    /**
     * Username of the customer on your system
     *
     * @var string
     */
    protected $customer_username;

    /**
     * Unique user identificator on your system
     *
     * @var string
     */
    protected $customer_unique_id;

    /**
     * Unique Transaction Id with info of the customer to be verified. Please note; if Transaction Id and Customer
     * Registration Id are rovided the system will use the Transaction Id. Please provide the Transaction Id or
     * the Customer Registration Id; one of them must be provided
     *
     * @var string
     */
    protected $transaction_unique_id;

    /**
     * Unique Customer Registration Id with info of the customer to be verified
     *
     * @var string
     */
    protected $reference_id;

    /**
     * 1 - Manual; 2 - OCR; 3 - Both;
     *
     * @var string
     */
    protected $method;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('upload_document');
    }

    /**
     * @param $method
     *
     * @return Upload
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setMethod($method)
    {
        return $this->allowedOptionsSetter(
            'method',
            IdentityDocumentMethods::getAll(),
            $method,
            'Invalid identity document verification method.'
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'doc_base64_content',
            'doc_mime_type',
            'method'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldsGroups = [
            'id'  => ['transaction_unique_id', 'reference_id']
        ];

        $this->requiredFieldsGroups = \Genesis\Utils\Common::createArrayObject($requiredFieldsGroups);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'customer_username'     => $this->customer_username,
            'customer_unique_id'    => $this->customer_unique_id,
            'transaction_unique_id' => $this->transaction_unique_id,
            'reference_id'          => $this->reference_id,
            'method'                => $this->method,
            'doc'                   => $this->getDoc(0),
            'doc2'                  => $this->getDoc(1),
            'doc3'                  => $this->getDoc(2),
            'doc4'                  => $this->getDoc(3),
        ];
    }
}

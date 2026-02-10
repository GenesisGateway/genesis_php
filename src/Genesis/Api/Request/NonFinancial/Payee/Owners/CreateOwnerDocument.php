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

namespace Genesis\Api\Request\NonFinancial\Payee\Owners;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Constants\NonFinancial\Payee\PayeeDocumentTypes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class CreateOwnerDocument
 *
 * Create a Document for an existing Owner.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee\Owners
 *
 * @method string getOwnerUniqueId()                     Returns the unique identifier of the Owner
 * @method string getDocumentDocumentType()              Returns the type of the Document being uploaded
 * @method string getDocumentFile()                      Returns the Document file, base64 encoded
 * @method $this  setDocumentDocumentType(string $value) Sets the type of the Document being uploaded
 * @method $this  setDocumentFile(string $value)         Sets the Document file, base64
 *
 */
class CreateOwnerDocument extends BaseRequest
{
    const REQUEST_PATH = 'payee/owners/:owner_unique_id/documents';

    /**
     * The unique identifier of the Owner.
     *
     * @var string
     */
    protected $owner_unique_id;

    /**
     * The type of the Document being uploaded. Possible values are defined in the PayeeDocumentTypes class.
     *
     * @var string
     */
    protected $document_document_type;

    /**
     * The Document file, base64 encoded. The file must be in PDF, PNG or JPG format. Maximum file size is 10 MB.
     * The file string begins with the mime type, for example: "data:application/pdf;base64, JVBERi0xLjQKJcfs...".
     * Mind the space after the comma.
     *
     * @var string Base64 encoded file content
     */
    protected $document_file;

    /**
     * CreateOwnerDocument constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Sets the owner unique ID
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setOwnerUniqueId($value)
    {
        $this->owner_unique_id = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with owner_unique_id and query parameters.
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':owner_unique_id',
                (string)$this->owner_unique_id,
                self::REQUEST_PATH
            )
        );
    }

    /**
     * Sets the required fields for the request.
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'owner_unique_id',
            'document_document_type',
            'document_file',
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues       = [
            'document_document_type' => PayeeDocumentTypes::getAll(),
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Returns the request structure.
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'document' => [
                'document_type' => $this->document_document_type,
                'file'          => $this->document_file,
            ]
        ];
    }
}

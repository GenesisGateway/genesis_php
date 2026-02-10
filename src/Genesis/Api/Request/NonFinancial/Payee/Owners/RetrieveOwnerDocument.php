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
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class RetrieveOwnerDocument
 *
 * Retrieve the details of a specific Owner document.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee\Owners
 *
 * @method string getOwnerUniqueId()    Returns the unique identifier of the Owner
 * @method string getDocumentUniqueId() Returns the unique identifier of the Owner document
 *
 */
class RetrieveOwnerDocument extends BaseRequest
{
    const REQUEST_PATH = 'payee/owners/:owner_unique_id/documents/:document_unique_id';

    /**
     * The unique identifier of the Owner.
     *
     * @var string
     */
    protected $owner_unique_id;

    /**
     * The unique identifier of the Owner document.
     *
     * @var string
     */
    protected $document_unique_id;

    /**
     * RetrieveOwnerDocument constructor.
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
     * Sets the document unique ID
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setDocumentUniqueId($value)
    {
        $this->document_unique_id = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with owner_unique_id and document_unique_id.
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $path = str_replace(
            ':owner_unique_id',
            (string)$this->owner_unique_id,
            self::REQUEST_PATH
        );

        $this->setRequestPath(
            str_replace(
                ':document_unique_id',
                (string)$this->document_unique_id,
                $path
            )
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'owner_unique_id',
            'document_unique_id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Configures a Secured GET Request
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->setGetRequest();
    }

    /**
     * Returns an empty request structure (GET requests don't need a body).
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}

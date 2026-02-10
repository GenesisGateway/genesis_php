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

namespace Genesis\Api\Request\NonFinancial\Payee\Verifications;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class RetrievePayeeVerification
 *
 * Retrieve the details of a specific Payee Verification.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee\Verifications
 *
 * @method string getPayeeUniqueId()        Returns the unique identifier of the Payee
 * @method string getVerificationUniqueId() Returns the unique identifier of the Verification
 * @method $this  setPayeeUniqueId($value)  Sets the unique identifier of the Payee
 *
 */
class RetrievePayeeVerification extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id/verifications/:verification_unique_id';

    /**
     * The unique identifier of the Verification.
     *
     * @var string
     */
    protected $verification_unique_id;

    /**
     * RetrieveVerification constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Sets the verification unique ID
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setVerificationUniqueId($value)
    {
        $this->verification_unique_id = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with payee_unique_id and verification_unique_id.
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $path = str_replace(
            ':payee_unique_id',
            (string)$this->payee_unique_id,
            self::REQUEST_PATH
        );

        $this->setRequestPath(
            str_replace(
                ':verification_unique_id',
                (string)$this->verification_unique_id,
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
            'payee_unique_id',
            'verification_unique_id'
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

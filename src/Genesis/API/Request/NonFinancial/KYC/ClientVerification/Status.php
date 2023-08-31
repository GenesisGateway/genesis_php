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

namespace Genesis\API\Request\NonFinancial\KYC\ClientVerification;

use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest as KYCBaseRequest;
use Genesis\Utils\Common;
use Genesis\API\Traits\Request\Financial\ReferenceAttributes;

/**
 * class Status
 *
 * Verification status check request can be performed by reference_id.
 * A status check may be needed if async notification has not arrived yet or when kyc notifications
 * are not used in general.
 *
 * @package Genesis\API\Request\NonFinancial\KYC\ClientVerification
 *
 * @method setReferenceId($refId)
 */
class Status extends KYCBaseRequest
{
    use ReferenceAttributes;

    /**
     * Define Verifications Status endpoint
     *
     */
    public function __construct()
    {
        parent::__construct('verifications/status');
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'reference_id',
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }

    /**
     * Get the request structure
     *
     * @return string[]
     */
    protected function getRequestStructure()
    {
        return [
            'reference_id' => $this->reference_id,
        ];
    }
}

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
 * Class CreatePayeeVerification
 *
 * Trigger a Payee Verification.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee\Verification
 *
 * @method string getVerificationNotificationUrl()
 *      Returns the URL to which the Verification API will send notifications (webhooks) about status changes.
 * @method string getVerificationRedirectUrl()
 *      Returns the URL to which the user will be redirected if additional information is required.
 * @method $this setVerificationNotificationUrl(string $verification_notification_url)
 *      Sets the URL to which the Verification API will send notifications (webhooks) about status changes.
 * @method $this setVerificationRedirectUrl(string $verification_redirect_url)
 *      Sets the URL to which the user will be redirected if additional information is required.
 *
 */
class CreatePayeeVerification extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id/verifications';

    /**
     * The URL to which the Verification API will send notifications (webhooks) about status changes.
     *
     * @var string
     */
    protected $verification_notification_url;

    /**
     * The URL to which the user will be redirected if additional information is required.
     *
     * @var string
     */
    protected $verification_redirect_url;

    /**
     * CreateVerification constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Updates the request path with payee_unique_id.
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':payee_unique_id',
                (string)$this->payee_unique_id,
                self::REQUEST_PATH
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
            'payee_unique_id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Returns the request structure.
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'verification' => [
                'notification_url' => $this->verification_notification_url,
                'redirect_url'     => $this->verification_redirect_url
            ]
        ];
    }
}

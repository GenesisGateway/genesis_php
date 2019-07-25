<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Base\NonFinancial\KYC;

use Genesis\API\Request;
use Genesis\Builder;

/**
 * Class BaseRequest
 *
 * Genesis KYC Services gives us the ability to perform particular checks on the integrity of the consumer data.
 * Based on the returned consumer score we can decide whether we want to reject/approve a given transaction
 * or perform another action for this consumer.
 *
 * @package Genesis\API\Request\Base\NonFinancial\KYC
 */
abstract class BaseRequest extends Request
{
    const DEVICE_FINGERPRINT_TYPE_CUSTOM       = 1;
    const DEVICE_FINGERPRINT_TYPE_OPEN_SOURCE  = 2;
    const DEVICE_FINGERPRINT_TYPE_OPEN_SOURCE2 = 3;

    const PROFILE_ACTION_TYPE_REGISTRATION     = 1;
    const PROFILE_ACTION_TYPE_PROFILE_UPDATE   = 2;

    const PROFILE_CURRENT_STATUS_UNDEFINED     = 0;
    const PROFILE_CURRENT_STATUS_REVIEW        = 1;
    const PROFILE_CURRENT_STATUS_DENIED        = 2;
    const PROFILE_CURRENT_STATUS_APPROVED      = 3;

    const INDUSTRY_TYPE_FINANCE                = 1;
    const INDUSTRY_TYPE_GAMBLING               = 2;
    const INDUSTRY_TYPE_CRYPTO                 = 3;
    const INDUSTRY_TYPE_TRAVEL                 = 4;
    const INDUSTRY_TYPE_RETAIL                 = 5;
    const INDUSTRY_TYPE_RISK_VENDOR            = 6;
    const INDUSTRY_TYPE_ADULT                  = 7;
    const INDUSTRY_TYPE_REMITTANCE_TRANSFER    = 8;
    const INDUSTRY_TYPE_OTHER                  = 9;

    const DOCUMENT_TYPE_SSN                    = 0;
    const DOCUMENT_TYPE_PASSPORT_REGISTRY      = 1;
    const DOCUMENT_TYPE_PERSONAL_ID            = 2;
    const DOCUMENT_TYPE_IDENTITY_CARD          = 3;
    const DOCUMENT_TYPE_DRIVER_LICENSE         = 4;
    const DOCUMENT_TYPE_TRAVEL_DOCUMENT        = 8;
    const DOCUMENT_TYPE_RESIDENCE_PERMIT       = 12;
    const DOCUMENT_TYPE_IDENTITY_CERTIFICATE   = 13;
    const DOCUMENT_TYPE_FEDERAL_REGISTER       = 16;
    const DOCUMENT_TYPE_ELECTRON_CREDENTIALS   = 17;
    const DOCUMENT_TYPE_CPF                    = 18;

    const GENDER_MALE                          = 'M';
    const GENDER_FEMALE                        = 'F';

    const PAYMENT_METHOD_CREDIT_CARD           = 'CC';
    const PAYMENT_METHOD_ECHECK                = 'EC';
    const PAYMENT_METHOD_EWALLET               = 'EW';

    const CVV_PRESENT_YES                      = 'Yes';
    const CVV_PRESENT_NO                       = 'No';

    const TRANSACTION_STATUS_APPROVED        = 1;
    const TRANSACTION_STATUS_PRE_AUTH        = 2;
    const TRANSACTION_STATUS_SETTLED         = 3;
    const TRANSACTION_STATUS_VOID            = 4;
    const TRANSACTION_STATUS_REJECTED        = 5;
    const TRANSACTION_STATUS_DECLINED        = 6;
    const TRANSACTION_STATUS_CHARGEBACK      = 7;
    const TRANSACTION_STATUS_RETURN          = 8;
    const TRANSACTION_STATUS_PENDING         = 9;
    const TRANSACTION_STATUS_PASS            = 10;
    const TRANSACTION_STATUS_FAILED          = 11;
    const TRANSACTION_STATUS_REFUND          = 12;
    const TRANSACTION_STATUS_APPROVED_REVIEW = 13;
    const TRANSACTION_STATUS_ABANDON         = 14;

    const IDENTITY_DOCUMENT_METHOD_MANUAL    = 1;
    const IDENTITY_DOCUMENT_METHOD_OCR       = 2;
    const IDENTITY_DOCUMENT_METHOD_BOTH      = 3;

    const CALL_SERVICE_TYPE_SMS              = 1;
    const CALL_SERVICE_TYPE_VOICE            = 2;

    const CALL_VERIFICATION_STATUS_IN_PROGRESS          = 1;
    const CALL_VERIFICATION_STATUS_FAILED               = 2;
    const CALL_VERIFICATION_STATUS_VERIFICATION_FAILED  = 3;
    const CALL_VERIFICATION_STATUS_VERIFICATION_SUCCESS = 4;
    const CALL_VERIFICATION_STATUS_ABANDON              = 5;

    /**
     * @var string
     */
    private $requestPath;
    /**
     * KYC constructor.
     *
     * @param string $requestPath
     */
    public function __construct($requestPath)
    {
        $this->requestPath = $requestPath;

        parent::__construct(Builder::JSON);
    }

    abstract protected function getRequestStructure();

    /**
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initJsonConfiguration();
        $this->initApiGatewayConfiguration('kyc_service/' . $this->requestPath, false);
    }
    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $this->treeStructure = \Genesis\Utils\Common::createArrayObject(
            $this->getRequestStructure()
        );
    }
}

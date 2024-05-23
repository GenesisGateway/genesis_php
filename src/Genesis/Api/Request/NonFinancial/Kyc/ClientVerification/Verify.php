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

namespace Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest as KYCBaseRequest;
use Genesis\Api\Traits\Request\Financial\ReferenceAttributes;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycBackgroundChecksVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycDocumentVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycFaceVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerifications;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * class Verify
 *
 * The verification request will provide a link that will be used to redirect the customer.
 * The customer will provide the required documents and will be verified against them.
 * As a result, the user will be redirected back to merchant based on the provided redirect URL.
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\ClientVerification
 *
 * @method $this  setEmail($value);
 * @method $this  setRedirectUrl($value);
 * @method $this  setBacksideProofRequired($value);
 * @method $this  setAddressBacksideProofRequired($value);
 * @method $this  setAllowRetry($value);
 * @method string getEmail();
 * @method string getRedirectUrl();
 * @method bool   getBacksideProofRequired();
 * @method bool   getAddressBacksideProofRequired();
 * @method bool   getAllowRetry();
 */
class Verify extends KYCBaseRequest
{
    use KycBackgroundChecksVerifications;
    use KycDocumentVerifications;
    use KycFaceVerifications;
    use KycVerifications;
    use ReferenceAttributes;

    const REFERENCE_ID_MIN_LENGTH = 6;
    const REFERENCE_ID_MAX_LENGTH = 250;

    /**
     * User's email
     *
     * @var string
     */
    protected $email;

    /**
     * URL where the customer is sent to after completing the verification process
     *
     * @var string
     */
    protected $redirect_url;

    /**
     * Signifies that both sides of the document are required to verify the identity
     *
     * @var bool
     */
    protected $backside_proof_required;

    /**
     * Signifies that both sides of the document are required to verify the address
     *
     * @var bool
     */
    protected $address_backside_proof_required;

    /**
     * If the parameter value is set to 'true', the customer will be able to retry if the verification request is
     * declined by the AI. On retry, the customer can re-upload the verification proof after
     * correcting the indicated issues.
     *
     * @var bool
     */
    protected $allow_retry;

    /**
     * Define Verifications request endpoint
     *
     */
    public function __construct()
    {
        parent::__construct('verifications');
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'email',
            'redirect_url',
            'document_supported_types',
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }

    /**
     * Return the required parameters keys which values could evaluate as empty
     * Example value:
     * array(
     *     'class_property' => 'request_structure_key'
     * )
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return array(
            'face_allow_offline'           => 'allow_offline',
            'face_allow_online'            => 'allow_online',
            'face_check_duplicate_request' => 'check_duplicate_request',
            'expiry_date'                  => 'expiry_date'
        );
    }

    /**
     * Verify Reference ID value
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setReferenceId($value)
    {
        if (empty($value)) {
            $this->reference_id = null;

            return $this;
        }

        return $this->setLimitedString(
            'reference_id',
            $value,
            self::REFERENCE_ID_MIN_LENGTH,
            self::REFERENCE_ID_MAX_LENGTH
        );
    }

    /**
     * Get the request structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'email'                           => $this->email,
            'country'                         => $this->country,
            'language'                        => $this->language,
            'redirect_url'                    => $this->redirect_url,
            'reference_id'                    => $this->reference_id,
            'document_supported_types'        => $this->document_supported_types,
            'address_supported_types'         => $this->address_supported_types,
            'face'                            => $this->getVerificationFaceStructure(),
            'backside_proof_required'         => $this->backside_proof_required,
            'address_backside_proof_required' => $this->address_backside_proof_required,
            'expiry_date'                     => $this->getExpiryDate(),
            'allow_retry'                     => $this->allow_retry,
            'verification_mode'               => $this->verification_mode,
            'background_checks'               => $this->getVerificationBackgroundChecksStructure(),
            'document'                        => $this->getVerificationDocumentStructure()
        ];
    }
}

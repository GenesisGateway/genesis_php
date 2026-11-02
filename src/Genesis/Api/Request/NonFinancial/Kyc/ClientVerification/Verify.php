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

namespace Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest as KYCBaseRequest;
use Genesis\Api\Traits\Request\Financial\ReferenceAttributes;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycBackgroundChecksVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycDocumentVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycFaceVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerificationInstructions;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerificationsCommon;
use Genesis\Utils\Common;

/**
 * Class Verify
 *
 * The verification request will provide a link that will be used to redirect the customer.
 * The customer will provide the required documents and will be verified against them.
 * As a result, the user will be redirected back to merchant based on the provided redirect URL.
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\ClientVerification
 *
 * @method $this  setRedirectUrl($value);
 * @method $this  setAddressBacksideProofRequired($value);
 * @method $this  setAllowRetry($value);
 * @method string getRedirectUrl();
 * @method bool   getAddressBacksideProofRequired();
 * @method bool   getAllowRetry();
 * @method bool   getShowConsent();
 * @method bool   getShowPrivacyPolicy();
 * @method bool   getDocumentWithEnhancedData();
 * @method bool   getDocumentAllowFuzzyMatch();
 * @method bool   getDocumentAllowDeclineDuringSingleStep();
 * @method bool   getDocumentWithOpticalCharacterRecognitionForm();
 */
class Verify extends KYCBaseRequest
{
    use KycBackgroundChecksVerifications;
    use KycDocumentVerifications;
    use KycFaceVerifications;
    use KycVerificationInstructions;
    use KycVerifications;
    use KycVerificationsCommon;
    use ReferenceAttributes;

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
     * Whether the consent message is shown on the verification page
     *
     * @var bool
     */
    protected $show_consent;

    /**
     * Whether the privacy policy is shown on the verification page
     *
     * @var bool
     */
    protected $show_privacy_policy;

    /**
     * Request enhanced data extraction from the document
     *
     * @var bool
     */
    protected $document_with_enhanced_data;

    /**
     * Allow fuzzy matching of the document data
     *
     * @var bool
     */
    protected $document_allow_fuzzy_match;

    /**
     * Allow the verification to be declined during the single step flow
     *
     * @var bool
     */
    protected $document_allow_decline_during_single_step;

    /**
     * Show the OCR form to the customer
     *
     * @var bool
     */
    protected $document_with_optical_character_recognition_form;

    /**
     * Define Verifications request endpoint
     *
     */
    public function __construct()
    {
        parent::__construct('verifications');
    }

    /**
     * Set the correct value for Show Consent - boolean
     *
     * @param $value
     * @return $this
     */
    public function setShowConsent($value)
    {
        $this->show_consent = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Show Privacy Policy - boolean
     *
     * @param $value
     * @return $this
     */
    public function setShowPrivacyPolicy($value)
    {
        $this->show_privacy_policy = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Document With Enhanced Data - boolean
     *
     * @param $value
     * @return $this
     */
    public function setDocumentWithEnhancedData($value)
    {
        $this->document_with_enhanced_data = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Document Allow Fuzzy Match - boolean
     *
     * @param $value
     * @return $this
     */
    public function setDocumentAllowFuzzyMatch($value)
    {
        $this->document_allow_fuzzy_match = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Document Allow Decline During Single Step - boolean
     *
     * @param $value
     * @return $this
     */
    public function setDocumentAllowDeclineDuringSingleStep($value)
    {
        $this->document_allow_decline_during_single_step = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Document With Optical Character Recognition Form - boolean
     *
     * @param $value
     * @return $this
     */
    public function setDocumentWithOpticalCharacterRecognitionForm($value)
    {
        $this->document_with_optical_character_recognition_form = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'email'
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldsConditional = [
            'background_checks_verifications_business_incorporation_date' => [
                'background_checks_verifications_business_name'
            ]
        ];

        $this->requiredFieldsConditional = Common::createArrayObject($requiredFieldsConditional);
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
            'face_allow_offline'                               => 'allow_offline',
            'face_allow_online'                                => 'allow_online',
            'face_check_duplicate_request'                     => 'check_duplicate_request',
            'expiry_date'                                      => 'expiry_date',
            'show_consent'                                     => 'show_consent',
            'show_privacy_policy'                              => 'show_privacy_policy',
            'background_checks_with_alias_search'              => 'with_alias_search',
            'background_checks_with_associates_search'         => 'with_associates_search',
            'document_with_enhanced_data'                      => 'with_enhanced_data',
            'document_allow_fuzzy_match'                       => 'allow_fuzzy_match',
            'document_allow_decline_during_single_step'        => 'allow_decline_during_single_step',
            'document_with_optical_character_recognition_form' => 'with_optical_character_recognition_form',
            'verification_instructions_allow_paper_based'      => 'allow_paper_based',
            'verification_instructions_allow_photocopy'        => 'allow_photocopy',
            'verification_instructions_allow_laminated'        => 'allow_laminated',
            'verification_instructions_allow_screenshot'       => 'allow_screenshot',
            'verification_instructions_allow_cropped'          => 'allow_cropped',
            'verification_instructions_allow_scanned'          => 'allow_scanned'
        );
    }

    /**
     * Get the structure of the Verify-only document options
     *
     * @return array
     */
    protected function getDocumentOptionsStructure()
    {
        return [
            'with_enhanced_data'                      => $this->document_with_enhanced_data,
            'allow_fuzzy_match'                       => $this->document_allow_fuzzy_match,
            'allow_decline_during_single_step'        => $this->document_allow_decline_during_single_step,
            'with_optical_character_recognition_form' => $this->document_with_optical_character_recognition_form
        ];
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
            'document'                        => array_merge(
                $this->getVerificationDocumentStructure(),
                $this->getDocumentOptionsStructure()
            ),
            'show_consent'                    => $this->show_consent,
            'show_privacy_policy'             => $this->show_privacy_policy,
            'verification_instructions'       => $this->getVerificationInstructionsStructure()
        ];
    }
}

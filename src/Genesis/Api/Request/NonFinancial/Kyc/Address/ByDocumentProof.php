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

namespace Genesis\Api\Request\NonFinancial\Kyc\Address;

use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest as KYCBaseRequest;
use Genesis\Api\Traits\Request\Financial\ReferenceAttributes;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycDocumentVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerificationsCommon;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class ByProof
 *
 * Address verification by document proof
 *
 * Verification of customer address using a document.
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\Address
 *
 * @method bool getWithEnhancedAddressVerification()
 */
class ByDocumentProof extends KYCBaseRequest
{
    use ReferenceAttributes;
    use KycVerificationsCommon;
    use KycDocumentVerifications;

    /**
     * A flag to enable the enhanced address verification. The default value is 'false'.
     * This feature is disabled by default and can be enabled upon request through configuration.
     *
     * @var bool
     */
    protected $with_enhanced_address_verification;

    /**
     * Define Verifications request endpoint
     *
     */
    public function __construct()
    {
        parent::__construct('verifications/address/by_proof');
    }

    /**
     * Set with_enhanced_address_verification
     *
     * @param boolean $value
     *
     * @return $this
     */
    public function setWithEnhancedAddressVerification($value)
    {
        $this->with_enhanced_address_verification = CommonUtils::toBoolean($value);

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
            'reference_id',
            'document_supported_types',
            'document_full_address',
            'document_proof'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Return the request structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'reference_id'                       => $this->reference_id,
            'document_supported_types'           => $this->document_supported_types,
            'backside_proof_required'            => $this->backside_proof_required,
            'with_enhanced_address_verification' => $this->with_enhanced_address_verification,
            'document'                           => $this->getVerificationDocumentStructure()
        ];
    }
}

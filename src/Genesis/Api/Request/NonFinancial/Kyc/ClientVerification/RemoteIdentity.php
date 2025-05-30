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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest as KYCBaseRequest;
use Genesis\Api\Traits\Request\Financial\ReferenceAttributes;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycIdentityVerifications;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerificationsCommon;
use Genesis\Utils\Common;

/**
 * Class RemoteIdentity
 *
 * Used to verify documents provided by the customer
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\ClientVerification
 */
class RemoteIdentity extends KYCBaseRequest
{
    use KycIdentityVerifications;
    use KycVerificationsCommon;
    use ReferenceAttributes;

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
        $requiredFieldsGroups = [
            'required'  => ['email', 'reference_id']
        ];

        $this->requiredFieldsGroups = Common::createArrayObject($requiredFieldsGroups);
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
            'expiry_date' => 'expiry_date'
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
            'email'                    => $this->email,
            'reference_id'             => $this->reference_id,
            'country'                  => $this->country,
            'backside_proof_required'  => $this->backside_proof_required,
            'expiry_date'              => $this->getExpiryDate(),
            'document_supported_types' => $this->document_supported_types,
            'document'                 => $this->getIdentityDocumentStructure()
        ];
    }
}

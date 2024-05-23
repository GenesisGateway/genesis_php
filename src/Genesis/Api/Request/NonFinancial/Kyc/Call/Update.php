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

namespace Genesis\Api\Request\NonFinancial\Kyc\Call;

use Genesis\Api\Constants\NonFinancial\Kyc\CallVerificationStatuses;
use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest;
use Genesis\Api\Validators\Request\RegexValidator;

/**
 * Class Update
 *
 * This method is used to update the call status with the latest info received from the main system. It
 * also updates the transaction associated with this verification call.
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\Call
 */
class Update extends BaseRequest
{
    /**
     * Unique value to identify the call in back office.
     *
     * @var string
     */
    protected $reference_id;

    /**
     * Numeric value - 4 digits only. This is the value the customer entered in the verification window
     *
     * @var string
     */
    protected $security_code_input;

    /**
     * The first two values are defined by the system when the call is created; the ones accepted in this call
     * are the status 3; 4 and 5 only 1-In Progress; 2-Failed; 3-Verification Failed;
     * 4-Verification Successful; 5-Abandon;
     *
     * @var string
     */
    protected $verification_status;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('update_authentication');
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
            'security_code_input',
            'verification_status'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'verification_status' => CallVerificationStatuses::getAll(),
            'security_code_input' => new RegexValidator(RegexValidator::PATTERN_KYC_CALL_SECURITY_CODE)
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'reference_id'        => $this->reference_id,
            'security_code_input' => $this->security_code_input,
            'verification_status' => $this->verification_status
        ];
    }
}

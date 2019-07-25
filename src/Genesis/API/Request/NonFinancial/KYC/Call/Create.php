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

namespace Genesis\API\Request\NonFinancial\KYC\Call;

use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use Genesis\API\Validators\Request\RegexValidator;

/**
 * Class Download
 *
 * This method is used to make a call or send an SMS to a given phone number. This method is used to
 * complement the verification process. The system will make a call and dictates the verification code to
 * be typed in the website.
 *
 * @package Genesis\API\Request\NonFinancial\KYC\Call
 */
class Create extends BaseRequest
{
    /**
     * Username of the customer on your system
     *
     * @var string
     */
    protected $customer_username;

    /**
     * Unique user identificator on your system
     *
     * @var string
     */
    protected $customer_unique_id;

    /**
     * Transaction identification in the merchants system; If not provided the system won't be able to
     * link with the transaction that is being verified
     *
     * @var string
     */
    protected $transaction_unique_id;

    /**
     * Phone number to call; It must be complete country code + phone number; No dashes; For example: 50622560000
     *
     * @var string
     */
    protected $customer_phone_number;

    /**
     * @var string
     */
    protected $service_language;

    /**
     * Numeric value - 4 digits only; It cannot start with 0;
     * The boot is going to say this numeric value so the user can type it back on the website;
     *
     * @var string
     */
    protected $security_code;

    /**
     * Numeric value to indicate if the system will send a text message
     * or make a voice call; 1 for SMS; 2 for Voice call;
     *
     * @var string
     */
    protected $service_type;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('create_authentication');
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'customer_unique_id',
            'transaction_unique_id',
            'customer_phone_number',
            'service_language',
            'security_code',
            'service_type'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'service_language'      => [
                'a', 'ar-EG', 'bg', 'zh-HK', 'ca', 'hr', 'cs', 'da', 'nl', 'en-AU', 'en-GB', 'en-US', 'et', 'fil',
                'fi', 'fr', 'fr-CA', 'de', 'el', 'he', 'hi', 'hu', 'is', 'id', 'it', 'ja', 'ko', 'lv', 'ln', 'lt',
                'zh-CN', 'no', 'pl', 'pt-BR', 'pt', 'ro', 'ru', 'sk', 'es', 'es-419', 'sv', 'th', 'tr', 'uk', 'vi'
            ],
            'service_type'          => [
                self::CALL_SERVICE_TYPE_SMS,
                self::CALL_SERVICE_TYPE_VOICE
            ],
            'security_code'         => new RegexValidator(RegexValidator::PATTERN_KYC_CALL_SECURITY_CODE),
            'customer_phone_number' => new RegexValidator('/^\d+$/')
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'customer_username'     => $this->customer_username,
            'customer_unique_id'    => $this->customer_unique_id,
            'transaction_unique_id' => $this->transaction_unique_id,
            'customer_phone_number' => $this->customer_phone_number,
            'service_language'      => $this->service_language,
            'security_code'         => $this->security_code,
            'service_type'          => intval($this->service_type)
        ];
    }
}

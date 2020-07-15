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

namespace Genesis\API\Validators\Request;

use Genesis\Utils\Common as CommonUtils;

/**
 * Class RegexValidator
 * @package Genesis\API\Validators\Request
 */
class RegexValidator extends \Genesis\API\Validators\Request\Base\Validator
{
    /**
     * CC Regex Validation Patterns
     */
    const PATTERN_CREDIT_CARD_HOLDER    = '/\A(?!\A[\d\s]*\Z).+\s+.+\Z/';
    const PATTERN_CREDIT_CARD_NUMBER    = '/\A[0-9]{13,19}\Z/';
    const PATTERN_CREDIT_CARD_CVV       = '/\A[0-9]{3,4}\Z/';
    const PATTERN_CREDIT_CART_EXP_MONTH = '/^(0?[1-9]|1[012])$/';
    const PATTERN_CREDIT_CART_EXP_YEAR  = '/^(20)\d{2}$/';

    /**
     * GiftCards Regex Validation Patterns
     */
    const PATTERN_GIFT_CARD_NUMBER      = '/^\d+$/';

    /**
     * Must be a 10 digits Russian valid mobile number(either with or without international prefix +7),
     * or International mobile phone number, starting with + followed by at least 9 digits.
     */
    const PATTERN_QIWI_PHONE_NUMBER = '/^(\d{10}|\+7\d{10}|\+\d{9,30})$/';

    /**
     * Vouchers Regex Validation Patterns
     */
    const PATTERN_NEOSURF_VOUCHER_NUMBER = '/^[A-Za-z0-9]{1,10}$/';

    /**
     * DE IBAN validation. Used in PPRO GiroPay
     */
    const PATTERN_DE_IBAN = '/DE[0-9]{20}/';

    /**
     * Numeric value - 4 digits only; It cannot start with 0;
     */
    const PATTERN_KYC_CALL_SECURITY_CODE = '/^[1-9][0-9]{3}$/';

    /**
     * Virtual Payment Address (VPA) of the customer, format: someone@bank
     */
    const PATTERN_VIRTUAL_PAYMENT_ADDRESS = '/^.+@.+$/';

    /**
     * Regex expression
     *
     * @var string
     */
    protected $pattern;

    /**
     * RegexValidator constructor.
     *
     * @param string $pattern
     * @param null|string $message
     */
    public function __construct($pattern, $message = null)
    {
        parent::__construct($message);

        $this->pattern = $pattern;
    }

    /**
     * Execute field name validation
     *
     * @return bool
     */
    protected function validate()
    {
        if (!CommonUtils::isRegexExpr($this->pattern)) {
            return false;
        }

        return (bool) preg_match(
            $this->pattern,
            $this->getRequestValue()
        );
    }
}

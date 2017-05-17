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
    const PATTERN_CREDIT_CARD_HOLDER    = '/^[\p{L}\'\-,.]+[ ]+[\p{L}\'\-,. ]+$/u';
    const PATTERN_CREDIT_CARD_NUMBER    = '/\A[0-9]{13,19}\Z/';
    const PATTERN_CREDIT_CARD_CVV       = '/\A[0-9]{3,4}\Z/';
    const PATTERN_CREDIT_CART_EXP_MONTH = '/^(0?[1-9]|1[012])$/';
    const PATTERN_CREDIT_CART_EXP_YEAR  = '/^(20)\d{2}$/';

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

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
namespace Genesis\API\Constants\Payment;

/**
 * Class Methods
 *
 * Payment methods for Genesis Transactions
 *
 * @package Genesis\API\Constants\Transaction
 */
class Methods
{
    /**
     * e-payment standard
     *
     * PPRO transaction
     */
    const EPS = 'eps';

    /**
     * GiroPay
     *
     * PPRO transaction
     */
    const GIRO_PAY = 'giropay';

    /**
     * iDEAL
     *
     * PPRO transaction
     */
    const IDEAL = 'ideal';

    /**
     * Przelewy24
     *
     * PPRO transaction
     */
    const PRZELEWY24 = 'przelewy24';

    /**
     * SafetyPay
     *
     * PPRO transaction
     */
    const SAFETY_PAY = 'safetypay';

    /**
     * TrustPay
     *
     * PPRO transaction
     */
    const TRUST_PAY = 'trustpay';

    /**
     * Mr.Cash
     *
     * PPRO transaction
     */
    const BCMC = 'bcmc';

    /**
     * MyBank
     *
     * PPRO transaction
     */
    const MYBANK = 'mybank';

    /**
     * Returns all available payment methods
     * @return array
     */
    public static function getMethods()
    {
        $methods = \Genesis\Utils\Common::getClassConstants(__CLASS__);

        return array_values($methods);
    }
}

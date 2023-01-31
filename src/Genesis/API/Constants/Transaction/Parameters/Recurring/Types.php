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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Constants\Transaction\Parameters\Recurring;

/**
 * List of available Recurring Types
 *
 * class Types
 */
class Types
{
    /**
     * Indication for an Initial Recurring Transaction. Respond to Init_Recurring
     */
    const INITIAL    = 'initial';

    /**
     * Indication for a Managed Recurring Transaction. Respond to Managed Recurring transactions.
     */
    const MANAGED    = 'managed';

    /**
     * Indication for a Subsequent Transaction on the Initial Recurring. Respond to subsequent Recurring payments.
     */
    const SUBSEQUENT = 'subsequent';

    /**
     * Return all Initial Recurring Types
     *
     * @return string[]
     */
    public static function getInitialTypes()
    {
        return array(
            self::INITIAL,
            self::MANAGED
        );
    }

    /**
     * Return all Subsequent Types
     *
     * @return string[]
     */
    public static function getSubsequentTypes()
    {
        return array(
            self::SUBSEQUENT
        );
    }
}

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

namespace Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Purchase;

use Genesis\Utils\Common;

/**
 * Identifies the type of transaction being authenticated. This field is required in some markets.
 *
 * Class Categories
 * @package Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Purchase
 */
class Categories
{
    /**
     * Goods
     */
    const GOODS              = 'goods';

    /**
     * Service
     */
    const SERVICE            = 'service';

    /**
     * Acceptance check
     */
    const CHECK_ACCEPTANCE   = 'check_acceptance';

    /**
     * Funding account
     */
    const ACCOUNT_FUNDING    = 'account_funding';

    /**
     * Cash quasi
     */
    const QUASI_CASH         = 'quasi_cash';

    /**
     * Prepaid activation
     */
    const PREPAID_ACTIVATION = 'prepaid_activation';

    /**
     * Load
     */
    const LOAN               = 'loan';

    /**
     * Get all the Categories
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}

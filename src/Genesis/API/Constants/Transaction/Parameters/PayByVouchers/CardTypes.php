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
namespace Genesis\API\Constants\Transaction\Parameters\PayByVouchers;

/**
 * Class CardTypes
 *
 * CardTypes of PayByVouchers Genesis Transaction
 *
 * @package Genesis\API\Constants\Transaction\Parameters\PayByVouchers
 *
 */
class CardTypes
{
    /**
     * The type of the issued card will be virtual
     */
    const VIRTUAL = 'virtual';

    /**
     * The type of the issued card will be physical
     */
    const PHYSICAL = 'physical';

    /**
     * Check if a card type is supported
     *
     * @param $cardType
     * @return string
     */
    public static function isValidCardType($cardType)
    {
        if (@constant('self::' . strtoupper($cardType))) {
            return true;
        }

        return false;
    }

    /**
     * Returns all available Card Types
     * @return array
     */
    public static function getCardTypes()
    {
        $methods = \Genesis\Utils\Common::getClassConstants(__CLASS__);

        return array_values($methods);
    }
}

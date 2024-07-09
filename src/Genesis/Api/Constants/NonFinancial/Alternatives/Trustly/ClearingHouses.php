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

namespace Genesis\Api\Constants\NonFinancial\Alternatives\Trustly;

use Genesis\Utils\Common;

/**
 * Class ClearingHouses
 * @package Genesis\Api\Constants\NonFinancial\Alternatives\Trustly
 */
class ClearingHouses
{
    const AUSTRIA = 'AUSTRIA';

    const BELGIUM = 'BELGIUM';

    const BULGARIA = 'BULGARIA';

    const CROATIA = 'CROATIA';

    const CYPRUS = 'CYPRUS';

    const CZECH_REPUBLIC = 'CZECH_REPUBLIC';

    const DENMARK = 'DENMARK';

    const ESTONIA = 'ESTONIA';

    const FINLAND = 'FINLAND';

    const FRANCE = 'FRANCE';

    const GERMANY = 'GERMANY';

    const GREECE = 'GREECE';

    const HUNGARY = 'HUNGARY';

    const IRELAND = 'IRELAND';

    const ITALY = 'ITALY';

    const LATVIA = 'LATVIA';

    const LITHUANIA = 'LITHUANIA';

    const LUXEMBOURG = 'LUXEMBOURG';

    const MALTA = 'MALTA';

    const NETHERLANDS = 'NETHERLANDS';

    const NORWAY = 'NORWAY';

    const POLAND = 'POLAND';

    const PORTUGAL = 'PORTUGAL';

    const ROMANIA = 'ROMANIA';

    const SLOVAKIA = 'SLOVAKIA';

    const SLOVENIA = 'SLOVENIA';

    const SPAIN = 'SPAIN';

    const SWEDEN = 'SWEDEN';

    const UNITED_KINGDOM = 'UNITED_KINGDOM';

    /**
     * Retrieve all clearing houses
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}

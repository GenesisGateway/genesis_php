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

namespace Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Utils\Common;

/**
 * Class MpiProtocolSubVersions
 *
 * Constants for 3DS MPI parameters Transaction
 *
 * @package Genesis\Api\Constants\Transaction\Parameters
 */
class MpiProtocolSubVersions
{
    /**
     * Sub-protocol Version 1
     */
    const PROTOCOL_SUB_VERSION_1 = '1';

    /**
     * Sub-protocol Version 2
     */
    const PROTOCOL_SUB_VERSION_2 = '2';

    /**
     * Sub-protocol Version 3
     */
    const PROTOCOL_SUB_VERSION_3 = '3';

    /**
     * Sub-protocol Version 4
     */
    const PROTOCOL_SUB_VERSION_4 = '4';

    /**
     * Sub-protocol Version 5
     */
    const PROTOCOL_SUB_VERSION_5 = '5';

    /**
     * Sub-protocol Version 6
     */
    const PROTOCOL_SUB_VERSION_6 = '6';

    /**
     * Sub-protocol Version 7
     */
    const PROTOCOL_SUB_VERSION_7 = '7';

    /**
     * Sub-protocol Version 8
     */
    const PROTOCOL_SUB_VERSION_8 = '8';

    /**
     * Sub-protocol Version 9
     */
    const PROTOCOL_SUB_VERSION_9 = '9';

    /**
     * Get protocol sub-versions array
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(__CLASS__);
    }
}

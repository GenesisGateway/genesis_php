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

namespace Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control;

use Genesis\Utils\Common;

/**
 * Identifies the size of the challenge window for the consumer.
 *
 * Class ChallengeWindowSizes
 * @package Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control
 */
class ChallengeWindowSizes
{
    /**
     *  Challenge Window Size 250x400
     */
    const SIZE_250X400     = '250x400';

    /**
     *  Challenge Window Size 390x400
     */
    const SIZE_390X400     = '390x400';

    /**
     *  Challenge Window Size 500x600
     */
    const SIZE_500X600     = '500x600';

    /**
     *  Challenge Window Size 600x400
     */
    const SIZE_600X400     = '600x400';

    /**
     * Challenge Window Size Full Screen
     */
    const FULLSCREEN = 'full_screen';

    /**
     * Get all the Challenge Window Sizes
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}

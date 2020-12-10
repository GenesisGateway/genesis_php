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

namespace Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control;

use Genesis\Utils\Common;

/**
 * The value has weight and might impact the decision whether a challenge will be required for the transaction or not.
 * If not provided, it will be interpreted as no_preference.
 *
 * Class ChallengeIndicators
 * @package Genesis\API\Constants\Transaction\Parameters\Threeds\V2
 */
class ChallengeIndicators
{
    /**
     * Don't have any preferences related to the Challenge flow (default)
     */
    const NO_PREFERENCE          = 'no_preference';

    /**
     * I prefer that a Challenge flow does not take place
     */
    const NO_CHALLENGE_REQUESTED = 'no_challenge_requested';

    /**
     * A request for the Challenge flow to take place
     */
    const PREFERENCE             = 'preference';

    /**
     * A Challenge flow must take place to fulfill a mandate
     */
    const MANDATE                = 'mandate';

    /**
     * Get all the Challenge Indicators
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}

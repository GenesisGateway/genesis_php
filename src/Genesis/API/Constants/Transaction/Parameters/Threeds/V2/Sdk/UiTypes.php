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

namespace Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Sdk;

use Genesis\Utils\Common;

/**
 * UI type that the device of the consumer supports for displaying specific challenge interface.
 *
 * Class UiTypes
 * @package Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Sdk
 */
class UiTypes
{
    /**
     * Text
     */
    const TEXT = 'text';

    /**
     * Single Select
     */
    const SINGLE_SELECT = 'single_select';

    /**
     * Multi Select
     */
    const MULTI_SELECT = 'multi_select';

    /**
     * Out of bag
     */
    const OUT_OF_BAG = 'out_of_bag';

    /**
     * Othre html
     */
    const OTHER_HTML = 'other_html';

    /**
     * Get all the Ui Types
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}

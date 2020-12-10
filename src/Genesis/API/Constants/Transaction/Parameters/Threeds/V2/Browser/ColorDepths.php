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

namespace Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Browser;

use Genesis\Utils\Common;

/**
 * Value representing the bit depth of the colour palette for displaying images, in bits per pixel.
 * Obtained from Cardholder browser using the screen.colorDepth property.
 *
 * Class ColorDepths
 * @package Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Browser
 */
class ColorDepths
{
    /**
     * Color Depth 1
     */
    const BIT_1  = 1;

    /**
     * Color Depth 4
     */
    const BITS_4  = 4;

    /**
     * Color Depth 8
     */
    const BITS_8  = 8;

    /**
     * Color Depth 15
     */
    const BITS_15 = 15;

    /**
     * Color Depth 16
     */
    const BITS_16 = 16;

    /**
     * Color Depth 24
     */
    const BITS_24 = 24;

    /**
     * Color Depth 32
     */
    const BITS_32 = 32;

    /**
     * Color Depth 48
     */
    const BITS_48 = 48;

    /**
     * Get all the available Color Depths
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}

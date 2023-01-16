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
namespace Genesis\API\Constants;

use Genesis\Utils\Common;

/**
 * Class DateTimeFormat
 *
 * List of DateTime format
 *
 * @package Genesis\API\Constants
 */
class DateTimeFormat
{
    /**
     * Little endian(day, month, year) system with hyphens in between
     */
    const DD_MM_YYYY_L_HYPHENS = 'd-m-Y';

    /**
     * Little endian(day, month, year) system with dots in between
     */
    const DD_MM_YYYY_L_DOTS = 'd.m.Y';

    /**
     * Little endian(day, month, year) system with dots in between
     */
    const DD_MM_YYYY_L_SLASHES = 'd/m/Y';

    /**
     * Zulu timestamp
     */
    const YYYY_MM_DD_H_I_S_ZULU = 'Y-m-d\TH:i:s\Z';

    /**
     * Date Format ISO 8601
     */
    const YYYY_MM_DD_ISO_8601 = 'Y-m-d';

    /**
     * Modified Zulu timestamp
     */
    const YYYY_MM_DD_H_I_S = 'Y-m-d H:i:s';

    /**
     * Retrieve list of all DateTime formats
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }

    /**
     * Get all Date Formats
     *
     * @return array
     */
    public static function getDateFormats()
    {
        return [
            self::DD_MM_YYYY_L_HYPHENS,
            self::DD_MM_YYYY_L_DOTS,
            self::DD_MM_YYYY_L_SLASHES,
            self::YYYY_MM_DD_ISO_8601
        ];
    }

    /**
     * Get All DateTime formats
     * @return array
     */
    public static function getDateTimeFormats()
    {
        return [
            self::YYYY_MM_DD_H_I_S,
            self::YYYY_MM_DD_H_I_S_ZULU
        ];
    }
}

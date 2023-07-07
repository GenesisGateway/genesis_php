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
 * Class i18n
 *
 * Get internationalisation (i18n) codes in ISO-639-1
 *
 * @package Genesis\API\Constants
 */
// @codingStandardsIgnoreStart
class i18n
// @codingStandardsIgnoreEnd
{
    /**
     * Arabic
     */
    const AR = 'ar';

    /**
     * Bulgarian
     */
    const BG = 'bg';

    /**
     * German
     */
    const DE = 'de';

    /**
     * English
     */
    const EN = 'en';

    /**
     * Spanish
     */
    const ES = 'es';

    /**
     * French
     */
    const FR = 'fr';

    /**
     * Hindu
     */
    const HI = 'hi';

    /**
     * Japanese
     */
    const JA = 'ja';

    /**
     * Icelandic
     */
    const IS = 'is';

    /**
     * Italian
     */
    const IT = 'it';

    /**
     * Dutch
     */
    const NL = 'nl';

    /**
     * Portuguese
     */
    const PT = 'pt';

    /**
     * Polish
     */
    const PL = 'pl';

    /**
     * Russian
     */
    const RU = 'ru';

    /**
     * Turkish
     */
    const TR = 'tr';

    /**
     * Mandarin Chinese
     */
    const ZH = 'zh';

    /**
     * Indonesian
     */
    const ID = 'id';

    /**
     * Malay
     */
    const MS = 'ms';

    /**
     * Thai
     */
    const TH = 'th';

    /**
     * Czech
     */
    const CS = 'cs';

    /**
     * Croatian
     */
    const HR = 'hr';

    /**
     * Slovenian
     */
    const SL = 'sl';

    /**
     * Finnish
     */
    const FI = 'fi';

    /**
     * Norwegian
     */
    const NO = 'no';

    /**
     * Danish
     */
    const DA = 'da';

    /**
     * Swedish
     */
    const SV = 'sv';

    /**
     * Check if a language code is supported
     *
     * @param $languageCode
     * @return string
     */
    public static function isValidLanguageCode($languageCode)
    {
        $languageConstant = 'self::' . strtoupper($languageCode);

        if (defined($languageConstant) && constant($languageConstant)) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve all languages
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(__CLASS__);
    }
}

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
namespace Genesis\API\Constants;

/**
 * Class i18n
 *
 * Get internationalisation (i18n) codes
 *
 * @package Genesis\API\Constants
 */
// @codingStandardsIgnoreStart
class i18n
// @codingStandardsIgnoreEnd
{
    /**
     * Arabic locale and language
     */
    const AR = 'Arabic';

    /**
     * Bulgarian locale and language
     */
    const BG = 'Bulgarian';

    /**
     * German locale and language
     */
    const DE = 'German';

    /**
     * English locale and language settings (this is the default)
     */
    const EN = 'English';

    /**
     * Spanish locale and language settings
     */
    const ES = 'Spanish';

    /**
     * French locale and language settings
     */
    const FR = 'French';

    /**
     * Hindu locale and language
     */
    const HI = 'Hindu';

    /**
     * Japanese locale and language
     */
    const JA = 'Japanese';

    /**
     * Icelandic locale and language
     */
    const IS = 'Icelandic';

    /**
     * Italian locale and language settings
     */
    const IT = 'Italian';

    /**
     * Dutch locale and language
     */
    const NL = 'Dutch';

    /**
     * Portuguese locale and language
     */
    const PT = 'Portuguese';

    /**
     * Polish locale and language
     */
    const PL = 'Polish';

    /**
     * Russian locale and language
     */
    const RU = 'Russian';

    /**
     * Turkish locale and language
     */
    const TR = 'Turkish';

    /**
     * Mandarin Chinese locale and language
     */
    const ZH = 'Chinese (Mandarin)';

    /**
     * Check if a language code is supported
     *
     * @param $languageCode
     * @return string
     */
    public static function isValidLanguageCode($languageCode)
    {
        if (@constant('self::' . strtoupper($languageCode))) {
            return true;
        }

        return false;
    }
}

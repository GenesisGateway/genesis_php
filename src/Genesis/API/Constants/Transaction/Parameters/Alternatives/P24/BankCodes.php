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

namespace Genesis\API\Constants\Transaction\Parameters\Alternatives\P24;

use Genesis\Utils\Common;

/**
 * Available bank codes for the P24 transaction type
 *
 * Class BankCodes
 * @package Genesis\API\Constants\Transaction\Parameters\Alternatives\P24
 */
class BankCodes
{
    /**
     * Bank Code for BLIK
     */
    const BLIK_PSP                   = 154;

    /**
     * Bank Code for EuroBank
     */
    const EURO_BANK                  = 94;

    /**
     * Bank Code for mBank-mTransfer
     */
    const MBANK_MTRANSFER            = 25;

    /**
     * Bank Code for Przekaz tradycyjny
     */
    const PRZEKAZ_TRADYCYJNY         = 178;

    /**
     * Bank Code for Przekaz/Przelew tradycyjny
     */
    const PRZEKAZ_PRZELEW_TRADYCYJNY = 1000;

    /**
     * Bank Code for Płac ̨e z IKO
     */
    const PLACEZ_IKO                 = 135;

    /**
     * Bank Code for Płac ̨e z Orange
     */
    const PLACEZ_ORANGE              = 146;

    /**
     * Bank Code for Raiffeisen Bank PBL
     */
    const RAIFFEISEN_BANK_PBL        = 102;

    /**
     * Bank Code for U ̇zyj przedpłaty
     */
    const UZYJ_PRZEDPLATY            = 177;

    /**
     * Get All available Bank Codes
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}

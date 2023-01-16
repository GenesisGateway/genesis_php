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

namespace Genesis\API\Constants\Transaction\Parameters\OnlineBanking\Ideal;

use Genesis\Utils\Common;

/**
 * Available issuers and their associated BIC
 *
 * Class AllowedBanks
 * @package Genesis\API\Constants\Transaction\Parameters\OnlineBanking\Ideal
 */
class AllowedBanks
{
    /**
     * Allowed BIC of issuer ABN Amro
     */
    const ABN_AMRO              = 'ABNANL2A';

    /**
     * Allowed BIC of issuer ASN
     */
    const ASN                   = 'ASNBNL21';

    /**
     * Allowed BIC of issuer Bunq
     */
    const BUNQ                  = 'BUNQNL2A';

    /**
     * Allowed BIC of issuer Handelsbanken
     */
    const HANDELSBANKEN         = 'HANDNL2A';

    /**
     * Allowed BIC of issuer ING Bank
     */
    const ING_BANK              = 'INGBNL2A';

    /**
     * Allowed BIC of issuer KNAB
     */
    const KNAB                  = 'KNABNL2H';

    /**
     * Allowed BIC of issuer Rabobank
     */
    const RABOBANK              = 'RABONL2U';

    /**
     * Allowed BIC of issuer Regio Bank
     */
    const REGIO_BANK            = 'RBRBNL21';

    /**
     * Allowed BIC of issuer Revolut
     */
    const REVOLUT               = 'REVOLT21';

    /**
     * Allowed BIC of issuer SNS Bank
     */
    const SNS_BANK              = 'SNSBNL2A';

    /**
     * Allowed BIC of issuer Triodos Bank
     */
    const TRIODOS_BANK          = 'TRIONL2U';

    /**
     * Allowed BIC of issuer Van Lanschot Bankiers
     */
    const VAN_LANSCHOT_BANKIERS = 'FVLBNL22';

    /**
     * Get all available BIC/SWIFT Codes
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}

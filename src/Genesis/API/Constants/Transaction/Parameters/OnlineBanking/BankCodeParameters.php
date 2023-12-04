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

namespace Genesis\API\Constants\Transaction\Parameters\OnlineBanking;

use Genesis\API\Constants\Banks;
use Genesis\Utils\Common;

/**
 * Class BankCodesConditionalValues
 * @package Genesis\API\Constants\Transaction\Parameters\OnlineBanking
 */
class BankCodeParameters
{
    /**
     * Available Currencies and Codes for OnlineBanking\Payin
     *
     * @var array $codes
     */
    private static $codes = [
        'BRL' => [
            Banks::CA
        ],
        'CAD' => [
            Banks::CPI
        ],
        'CHF' => [
            Banks::PF
        ],
        'CNY' => [
            Banks::ABC, Banks::BOB, Banks::BOC, Banks::BOCO, Banks::CCB,
            Banks::CCD, Banks::CEB, Banks::CIB, Banks::CMB, Banks::CMBC,
            Banks::CITIC, Banks::ICBC, Banks::GDB, Banks::HXB, Banks::PINGANBANK,
            Banks::PSBC, Banks::QUICKPAY, Banks::SHB, Banks::SPABANK, Banks::SPDB,
            Banks::YLB
        ],
        'CLP' => [
            Banks::SP
        ],
        'EUR' => [
            Banks::PF, Banks::BCT
        ],
        'THB' => [
            Banks::BBL_IB_U, Banks::KBANK_PAYPLUS, Banks::BAY_IB_U, Banks::KTB_IB_U,
            Banks::SCB_IB_U
        ],
        'USD' => [
            Banks::SN, Banks::IT, Banks::BR, Banks::BB, Banks::WP, Banks::BN, Banks::PS, Banks::BO
        ],
        'MYR' => [
            Banks::FPX_ABB, Banks::FPX_ABMB, Banks::FPX_AMB, Banks::FPX_BIMB, Banks::FPX_BMMB,
            Banks::FPX_BKRM, Banks::FPX_BSN, Banks::FPX_CIMBCLICKS, Banks::FPX_HLB, Banks::FPX_KFH,
            Banks::FPX_MB2U, Banks::FPX_OCBC, Banks::FPX_PBB, Banks::FPX_RHB, Banks::FPX_SCB,
            Banks::FPX_UOB
        ],
        'PEN' => [
            Banks::BC, Banks::IB, Banks::EF, Banks::BP
        ],
        'PYG' => [
            Banks::PE
        ],
        'IDR' => [
            Banks::DK_BCA_IB, Banks::DK_BRI_IB, Banks::DK_CIMBCLICKS_IB, Banks::DK_DANAMON_IB,
            Banks::DK_PERMATANET_IB
        ],
        'INR' => [
            Banks::ABPB, Banks::AIRP, Banks::ALLA, Banks::ANDB, Banks::BARB_R, Banks::BBKM, Banks::BKDN, Banks::BKID,
            Banks::CBIN, Banks::CIUB, Banks::CNRB, Banks::CORP, Banks::COSB, Banks::CSBK, Banks::DBSS, Banks::DCBL,
            Banks::DEUT, Banks::DLXB, Banks::ESFB, Banks::FDRL, Banks::HDFC, Banks::IBKL, Banks::ICIC, Banks::IDFB,
            Banks::IDIB, Banks::INDB, Banks::IOBA, Banks::JAKA, Banks::JSBP, Banks::KARB, Banks::KKBK, Banks::KVBL,
            Banks::LAVB_C, Banks::LAVB_R, Banks::MAHB, Banks::NKGS, Banks::ORBC, Banks::PMCB, Banks::PSIB,
            Banks::PUNB_R, Banks::RATN, Banks::SBBJ, Banks::SBHY, Banks::SBIN, Banks::SBMY, Banks::SBTR, Banks::SCBL,
            Banks::SIBL, Banks::SRCB, Banks::STBP, Banks::SVCB, Banks::SYNB, Banks::TMBL, Banks::TNSC, Banks::UBIN,
            Banks::UCBA, Banks::UTBI, Banks::UTIB, Banks::VIJB, Banks::YESB
        ],
        'MXN' => [
            Banks::SE, Banks::BQ
        ],
        'PHP' => [
            Banks::DRAGONPAY
        ],
        'SGD' => [
            Banks::DBS, Banks::UOB, Banks::OCBC, Banks::SCB
        ],
        'UYU' => [
            Banks::AI
        ],
        'VND' => [
            Banks::VTCP_VPBANK, Banks::VTCP_ABBANK, Banks::VTCP_ACB, Banks::VTCP_AGRIBANK,
            Banks::VTCP_BACABANK, Banks::VTCP_BIDV, Banks::VTCP_BVB, Banks::VTCP_DONGABANK,
            Banks::VTCP_EXIMBANK, Banks::VTCP_GPBANK, Banks::VTCP_HDBANK, Banks::VTCP_LVPB,
            Banks::VTCP_MB, Banks::VTCP_MARITIMEBANK, Banks::VTCP_NAMABANK, Banks::VTCP_NAVIBANK,
            Banks::VTCP_OCEANBANK, Banks::VTCP_PGBANK, Banks::VTCP_PHUONGDONG, Banks::VTCP_SHB,
            Banks::VTCP_SACOMBANK, Banks::VTCP_SAIGONBANK, Banks::VTCP_SEAABANK, Banks::VTCP_TECHCOMBANK,
            Banks::VTCP_TIENPHONGBANK, Banks::VTCP_VIB, Banks::VTCP_VIETABANK, Banks::VTCP_VIETCOMBANK,
            Banks::VTCP_VIETINBANK
        ],
        'PLN' => [
            Banks::BLK
        ]
    ];

    public static function getBankCodesPerCurrency($currency)
    {
        $currency = strtoupper($currency);

        if (array_key_exists($currency, self::$codes)) {
            return self::$codes[$currency];
        }

        return [];
    }

    public static function getAllowedCurrencies()
    {
        return Common::getArrayKeys(self::$codes);
    }
}

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

use Genesis\Utils\Common;

/**
 * Class Banks
 *
 * List of supported Banks
 *
 * @package Genesis\API\Constants
 */
class Banks
{
    /**
     * Industrial and Commercial Bank of China
     */
    const ICBC = 'ICBC';

    /**
     * China Merchants Bank
     */
    const CMBCHINA = 'CMBCHINA';

    /**
     * Agricultural Bank of China
     */
    const ABC = 'ABC';

    /**
     * China Construction Bank
     */
    const CCB = 'CCB';

    /**
     * Bank of Beijing
     */
    const BCCB = 'BCCB';

    /**
     * Bank of Communications
     */
    const BOCO = 'BOCO';

    /**
     * Industrial Bank
     */
    const CIB = 'CIB';

    /**
     * Bank of Nanjing
     */
    const NJCB = 'NJCB';

    /**
     * China Minsheng Banking Corp Ltd
     */
    const CMBC = 'CMBC';

    /**
     * China Everbright Bank
     */
    const CEB = 'CEB';

    /**
     * Bank of China
     */
    const BOC = 'BOC';

    /**
     * Ping An Bank
     */
    const PINGANBANK = 'PINGANBANK';

    /**
     * Bank of East Asia
     */
    const HKBEA = 'HKBEA';

    /**
     * Bank of Ningbo
     */
    const NBCB = 'NBCB';

    /**
     * China Citic Bank
     */
    const ECITIC = 'ECITIC';

    /**
     * Shenzhen Development Bank
     */
    const SDB = 'SDB';

    /**
     * Guangdong Development Bank
     */
    const GDB = 'GDB';

    /**
     * Bank of Shanghai
     */
    const SHB = 'SHB';

    /**
     * Shanghai Pudong Development Bank
     */
    const SPDB = 'SPDB';

    /**
     * China Post
     */
    const POST = 'POST';

    /**
     * BEIJING RURAL COMMERCIAL BANK
     */
    const BJRCB = 'BJRCB';

    /**
     * Hua Xia Bank Co Ltd'
     */
    const HXB = 'HXB';

    /**
     * Bank of Hangzhou
     */
    const HZBANK = 'HZBANK';

    /**
     * Shanghai Rural Commercial Bank
     */
    const SRCB = 'SRCB';

    /**
     * DirectDebit
     */
    const DB = 'DB';

    /**
     * Caixa
     */
    const CA = 'CA';

    /**
     * Servipag
     */
    const SP = 'SP';

    /**
     * Bank of Beijing
     */
    const BOB = 'BOB';

    /**
     * Bank for economic construction
     */
    const CCD = 'CCD';

    /**
     * China Merchants Bank
     */
    const CMB = 'CMB';

    /**
     * China Citic Bank
     */
    const CITIC = 'CITIC';

    /**
     * China Postal Savings Bank
     */
    const PSBC = 'PSBC';

    /**
     * China Union Pay
     */
    const QUICKPAY = 'QUICKPAY';

    /**
     * Shengzhen Ping An Bank
     */
    const SPABANK = 'SPABANK';

    /**
     * Yinlian Bank
     */
    const YLB = 'YLB';

    /**
     * Bancolombia
     */
    const PC = 'PC';

    /**
     * ALTO, Prima, ATM Bersama
     */
    const ATMVA = 'ATMVA';

    /**
     * Bank Central Asia
     */
    const BCA_IDR = 'BCA_IDR';

    /**
     * Bank Rakyat Indonesia
     */
    const BRI_IDR = 'BRI_IDR';

    /**
     * Bank Negara Indonesia
     */
    const BNI_IDR = 'BNI_IDR';

    /**
     * BTN Bank
     */
    const BTN_IDR = 'BTN_IDR';

    /**
     * CIMB Clicks Indonesia
     */
    const CIMB_IDR = 'CIMB_IDR';

    /**
     * Danamon Bank
     */
    const DMN_IDR = 'DMB_IDR';

    /**
     * Mandiri Bank
     */
    const MDR_IDR = 'MDR_IDR';

    /**
     * Permata Bank
     */
    const PMB_IDR = 'PMB_IDR';

    /**
     * Virtual Account Bank
     */
    const VA = '';

    /**
     * Netbanking
     */
    const NB = 'NB';

    /**
     * UPI
     */
    const UI = 'UI';

    /**
     * Spei
     */
    const SE = 'SE';

    /**
     * Banorte
     */
    const BQ = 'BQ';

    /**
     * 7-eleven stores
     */
    const CASH_711 = 'CASH-711';

    /**
     * Affin Bank
     */
    const FPX_ABB = 'FPX_ABB';
    const AFFIN_EPG = 'AFFIN-EPG';

    /**
     * Alliance Bank
     */
    const FPX_ABMB = 'FPX_ABMB';

    /**
     * Am Online
     */
    const FPX_AMB = 'FPX_AMB';
    const AMB_W2W = 'AMB-W2W';

    /**
     * Bank Islam
     */
    const FPX_BIMB = 'FPX_BIMB';
    const BANKISLAM = 'BANKISLAM';

    /**
     * Bank Muamalat
     */
    const FPX_BMMB = 'FPX_BMMB';

    /**
     * Bank Rakyat
     */
    const FPX_BKRM = 'FPX_BKRM';

    /**
     * Bank Simpanan Nasional
     */
    const FPX_BSN = 'FPX_BSN';

    /**
     * CIMB Clicks Bank
     */
    const CIMB_MYR = 'CIMB_MYR';
    const FPX_CIMBCLICKS = 'FPX_CIMBCLICKS';
    const CIMB_CLICKS = 'CIMB-CLICKS';

    /**
     * FPX
     */
    const FPX = 'FPX';

    /**
     * HLB Connect
     */
    const FPX_HLB = 'FPX_HLB';
    const HLB_ONL = 'HLB-ONL';

    /**
     * Hong Leong Bank
     */
    const HLE_MYR = 'HLE_MYR';

    /**
     * jmpay
     */
    const JOMPAY_PHP = 'jompay.php';

    /**
     * Kuwait Finance House
     */
    const FPX_KFN = 'FPX_KFN';

    /**
     * May Bank
     */
    const MAY_MYR = 'MAY_MYR';

    /**
     * Maybank2u
     */
    const FPX_MB2U = 'FPX_MB2U';
    const MB2U = 'MB2U';

    /**
     * OCBC Bank
     */
    const FPX_OCBC = 'FPX_OCBC';

    /**
     * PBeBank
     */
    const FPX_PBB = 'FPX_PBB';
    const PUBLICKBANK = 'PUBLICKBANK';

    /**
     * Public Bank
     */
    const PBE_MYR = 'PBE_MYR';

    /**
     * RHB Bank
     */
    const RHB_MYR = 'RHB_MYR';

    /**
     * RHB Now
     */
    const FPX_RHB = 'FPX_RHB';
    const RHB_ONL = 'RHB-ONL';

    /**
     * Stand Chart Bank
     */
    const FPX_SCB = 'FPX_SCB';

    /**
     * UOB Bank
     */
    const FPX_UOB = 'FPX_UOB';

    /**
     * BCP
     */
    const BC = 'BC';

    /**
     * Interbank
     */
    const IB = 'IB';

    /**
     * Pago Efectivo
     */
    const EF = 'EF';

    /**
     * BBVA
     */
    const BP = 'BP';

    /**
     * PagoExpress
     */
    const PE = 'PE';

    /**
     * Bangkok Bank
     */
    const BBL_THB = 'BBL_THB';
    const TH_PB_BBLPN = 'TH_PB_BBLPN';

    /**
     * Kasikorn Bank
     */
    const KKB_THB = 'KKB_THB';

    /**
     * Krungsri (Bank of Ayudhya Public Company Limited)
     */
    const BAY_THB = 'BAY_THB';
    const TH_PB_BAYPN = 'TH_PB_BAYPN';

    /**
     * Krung Thai Bank
     */
    const KTB_THB = 'KTB_THB';
    const TH_PB_KTBPN = 'TH_PB_KTBPN';

    /**
     * OMISE_TL
     */
    const OMISE_TL_PHP = 'OMISE_TL.php';

    /**
     * Siam Commercial Bank
     */
    const SCB_THB = 'SCB_THB';
    const TH_PB_SCBPN = 'TH_PB_SCBPN';

    /**
     * UOBT
     */
    const UOB_THB = 'UOB_THB';

    /**
     * Abitab
     */
    const AI = 'AI';

    /**
     * Dragonpay
     */
    const DRAGONPAY = 'DRAGONPAY';

    /**
     * SG eNETS
     */
    const ENETS_D = 'ENETS-D';

    /**
     * singpost
     */
    const SINGPOST_PHP = 'singpost.php';

    /**
     * VTC-Pay
     */
    const VTCP_VPBANK = 'VTCP_VPBANK';
    /**
     * VTC-Pay ABBANK
     */
    const VTCP_ABBANK = 'VTCP_ABBANK';
    /**
     * VTC-Pay ACB
     */
    const VTCP_ACB = 'VTCP_ACB';

    /**
     * VTC-Pay Agribank
     */
    const VTCP_AGRIBANK = 'VTCP_AGRIBANK';

    /**
     * VTC-Pay BACABANK
     */
    const VTCP_BACABANK = 'VTCP_BACABANK';

    /**
     * VTC-Pay BIDV
     */
    const VTCP_BIDV = 'VTCP_BIDV';

    /**
     * VTC-Pay BVB
     */
    const VTCP_BVB = 'VTCP_BVB';

    /**
     * VTC-Pay DongABank
     */
    const VTCP_DONGABANK = 'VTCP_DONGABANK';

    /**
     * VTC-Pay Eximbank
     */
    const VTCP_EXIMBANK = 'VTCP_EXIMBANK';

    /**
     * VTC-Pay GPBank
     */
    const VTCP_GPBANK = 'VTCP_GPBANK';

    /**
     * VTC-Pay HDBank
     */
    const VTCP_HDBANK = 'VTCP_HDBANK';

    /**
     * VTC-Pay LienVietPostBank
     */
    const VTCP_LVPB = 'VTCP_LVPB';

    /**
     * VTC-Pay MB
     */
    const VTCP_MB = 'VTCP_MB';

    /**
     * VTC-Pay MaritimeBank
     */
    const VTCP_MARITIMEBANK = 'VTCP_MARITIMEBANK';

    /**
     * VTC-Pay NamABank
     */
    const VTCP_NAMABANK = 'VTCP_NAMABANK';

    /**
     * VTC-Pay Navibank
     */
    const VTCP_NAVIBANK = 'VTCP_NAVIBANK';

    /**
     * VTC-Pay Oceanbank
     */
    const VTCP_OCEANBANK = 'VTCP_OCEANBANK';

    /**
     * VTC-Pay PGBank
     */
    const VTCP_PGBANK = 'VTCP_PGBANK';

    /**
     * VTC-Pay PHUONGDONG
     */
    const VTCP_PHUONGDONG = 'VTCP_PHUONGDONG';

    /**
     * VTC-Pay SHB
     */
    const VTCP_SHB = 'VTCP_SHB';

    /**
     * VTC-Pay Sacombank
     */
    const VTCP_SACOMBANK = 'VTCP_SACOMBANK';

    /**
     * VTC-Pay SaigonBank
     */
    const VTCP_SAIGON_BANK = 'VTCP-SAIGON_BANK';

    /**
     * VTC-Pay SeaABank
     */
    const VTCP_SEAABANK = 'VTCP_SEAABANK';

    /**
     * VTC-Pay Techcombank
     */
    const VTCP_TECHCOMBANK = 'VTCP_TECHCOMBANK';

    /**
     * VTC-Pay TienPhong Bank
     */
    const VTCP_TIENPHONGBANK = 'VTCP_TIENPHONGBANK';

    /**
     * VTC-Pay VIB
     */
    const VTCP_VIB = 'VTCP_VIB';

    /**
     * VTC-Pay VietABank
     */
    const VTCP_VIETABANK = 'VTCP_VIETABANK';

    /**
     * VTC-Pay Vietcombank
     */
    const VTCP_VIETCOMBANK = 'VTCP_VIETCOMBANK';

    /**
     * VTC-Pay Vietinbank
     */
    const VTCP_VIETINBANK = 'VTCP_VIETINBANK';

    /**
     * Retrieve list of all Bank Codes
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}

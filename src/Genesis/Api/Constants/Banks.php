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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Constants;

use Genesis\Utils\Common;

/**
 * Class Banks
 *
 * List of supported Banks
 *
 * @package Genesis\Api\Constants
 */
class Banks
{
    /**
     * Aditya Birla Idea Payments Bank
     */
    const ABPB = 'ABPB';

    /**
     * Airtel Payments Bank
     */
    const AIRP = 'AIRP';

    /**
     * Allahabad Bank
     */
    const ALLA = 'ALLA';

    /**
     * Andhra Bank
     */
    const ANDB = 'ANDB';

    /**
     * Bank of Baroda - Retail Banking
     */
    const BARB_R = 'BARB_R';

    /**
     * Bank of Bahrein and Kuwait
     */
    const BBKM = 'BBKM';

    /**
     * Dena Bank
     */
    const BKDN = 'BKDN';

    /**
     * Bank of India
     */
    const BKID = 'BKID';

    /**
     * Central Bank of India
     */
    const CBIN = 'CBIN';

    /**
     * City Union Bank
     */
    const CIUB = 'CIUB';

    /**
     * Canara Bank
     */
    const CNRB = 'CNRB';

    /**
     * Corporation Bank
     */
    const CORP = 'CORP';

    /**
     * Cosmos Co-operative Bank
     */
    const COSB = 'COSB';

    /**
     * Catholic Syrian Bank
     */
    const CSBK = 'CSBK';

    /**
     * Development Bank of Singapore
     */
    const DBSS = 'DBSS';

    /**
     * DCB Bank
     */
    const DCBL = 'DCBL';

    /**
     * Deutsche Bank
     */
    const DEUT = 'DEUT';

    /**
     * Dhanlaxmi Bank
     */
    const DLXB = 'DLXB';

    /**
     * Equitas Small Finance Bank
     */
    const ESFB = 'ESFB';

    /**
     * Federal Bank
     */
    const FDRL = 'FDRL';

    /**
     * HDFC Bank
     */
    const HDFC = 'HDFC';

    /**
     * IDBI
     */
    const IBKL = 'IBKL';

    /**
     * ICICI Bank
     */
    const ICIC = 'ICIC';

    /**
     * IDFC FIRST Bank
     */
    const IDFB = 'IDFB';

    /**
     * Indian Bank
     */
    const IDIB = 'IDIB';

    /**
     * Indusind Bank
     */
    const INDB = 'INDB';

    /**
     * Indian Overseas Bank
     */
    const IOBA = 'IOBA';

    /**
     * Jammu and Kashmir Bank
     */
    const JAKA = 'JAKA';

    /**
     * Janata Sahakari Bank (Pune)
     */
    const JSBP = 'JSBP';

    /**
     * Karnataka Bank
     */
    const KARB = 'KARB';

    /**
     * Kotak Mahindra Bank
     */
    const KKBK = 'KKBK';

    /**
     * Karur Vysya Bank
     */
    const KVBL = 'KVBL';

    /**
     * Lakshmi Vilas Bank - Corporate Banking
     */
    const LAVB_C = 'LAVB_C';

    /**
     * Lakshmi Vilas Bank - Retail Banking
     */
    const LAVB_R = 'LAVB_R';

    /**
     * Bank of Maharashtra
     */
    const MAHB = 'MAHB';

    /**
     * NKGSB Co-operative Bank
     */
    const NKGS = 'NKGS';

    /**
     * Oriental Bank of Commerce
     */
    const ORBC = 'ORBC';

    /**
     * Punjab & Maharashtra Co-operative Bank
     */
    const PMCB = 'PMCB';

    /**
     * Punjab & Sind Bank
     */
    const PSIB = 'PSIB';

    /**
     * Punjab National Bank - Retail Banking
     */
    const PUNB_R = 'PUNB_R';

    /**
     * RBL Bank
     */
    const RATN = 'RATN';

    /**
     * State Bank of Bikaner and Jaipur
     */
    const SBBJ = 'SBBJ';

    /**
     * State Bank of Hyderabad
     */
    const SBHY = 'SBHY';

    /**
     * State Bank of India
     */
    const SBIN = 'SBIN';

    /**
     * State Bank of Mysore
     */
    const SBMY = 'SBMY';

    /**
     * State Bank of Travancore
     */
    const SBTR = 'SBTR';

    /**
     * Standard Chartered Bank
     */
    const SCBL = 'SCBL';

    /**
     * South Indian Bank
     */
    const SIBL = 'SIBL';

    /**
     * State Bank of Patiala
     */
    const STBP = 'STBP';

    /**
     * Shamrao Vithal Co-operative Bank
     */
    const SVCB = 'SVCB';

    /**
     * Syndicate Bank
     */
    const SYNB = 'SYNB';

    /**
     * Tamilnadu Mercantile Bank
     */
    const TMBL = 'TMBL';

    /**
     * Tamilnadu State Apex Co-operative Bank
     */
    const TNSC = 'TNSC';

    /**
     * Union Bank of India
     */
    const UBIN = 'UBIN';

    /**
     * UCO Bank
     */
    const UCBA = 'UCBA';

    /**
     * United Bank of India
     */
    const UTBI = 'UTBI';

    /**
     * Axis Bank
     */
    const UTIB = 'UTIB';

    /**
     * Vijaya Bank
     */
    const VIJB = 'VIJB';

    /**
     * Yes Bank
     */
    const YESB = 'YESB';

    /**
     * Santander
     */
    const SN = 'SN';

    /**
     * Itau
     */
    const IT = 'IT';

    /**
     * Bradesco
     */
    const BR = 'BR';

    /**
     * Banco do Brasil
     */
    const BB = 'BB';

    /**
     * Webpay
     */
    const WP = 'WP';

    /**
     * Bancomer
     */
    const BN = 'BN';

    /**
     * Bancontact
     */
    const BCT = 'BCT';

    /**
     * PSE
     */
    const PS = 'PS';

    /**
     * Banco de Occidente
     */
    const BO = 'BO';

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
     * Interac Combined Pay-in
     */
    const CPI = 'CPI';

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
     * Bank Central Asia
     */
    const DK_BCA_IB = 'DK_BCA_IB';

    /**
     * Bank Rakyat Indonesia
     */
    const DK_BRI_IB = 'DK_BRI_IB';

    /**
     * BTN Bank
     */
    const BTN_IDR = 'BTN_IDR';

    /**
     * CIMB Clicks Indonesia
     */
    const DK_CIMBCLICKS_IB = 'DK_CIMBCLICKS_IB';

    /**
     * Danamon Bank
     */
    const DK_DANAMON_IB = 'DK_DANAMON_IB';

    /**
     * Mandiri Bank
     */
    const MDR_IDR = 'MDR_IDR';

    /**
     * Permata Bank
     */
    const DK_PERMATANET_IB = 'DK_PERMATANET_IB';

    /**
     * Virtual Account Bank
     */
    const VA = 'VA';

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
    const FPX_KFH = 'FPX_KFH';

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
     * Post Finance
     */
    const PF = 'PF';

    /**
     * Bangkok Bank
     */
    const BBL_IB_U = 'BBL_IB_U';

    /**
     * Kasikornbank PAYPLUS
     */
    const KBANK_PAYPLUS = 'KBANK_PAYPLUS';

    /**
     * Bank of Ayudhya (Krungsri)
     */
    const BAY_IB_U = 'BAY_IB_U';

    /**
     * Krung Thai Bank
     */
    const KTB_IB_U = 'KTB_IB_U';

    /**
     * Siam Commercial Bank
     */
    const SCB_IB_U = 'SCB_IB_U';

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
     * VTC-Pay VPBank
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
    const VTCP_SAIGONBANK = 'VTCP-SAIGONBANK';

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
     * DBS
     */
    const DBS = 'ENETS-D_DBS';

    /**
     * UOB
     */
    const UOB = 'ENETS-D_UOB';

    /**
     * OCBC
     */
    const OCBC = 'ENETS-D_OCBC';

    /**
     * SCB
     */
    const SCB = 'ENETS-D_SCB';

    /**
     * BL
     */
    const BLK = 'BLK';

    /**
     * TrueLayer
     */
    const TRL = 'TRL';

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

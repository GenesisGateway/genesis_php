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

namespace Genesis\API\Constants\Transaction\Parameters\OnlineBanking;

use Genesis\Utils\Common;

/**
 * Class PayoutBankParameters
 * @package Genesis\API\Constants\Transaction\Parameters\OnlineBanking
 */
class PayoutBankParameters
{
    /**
     * Available Currencies and Bank Names for OnlineBanking\Payout
     *
     * @var array $names
     */
    private static $names = [
        'CNY' => [
            '中国银行', '中国交通银行', '中信银行', '上海浦发银行', '中国农业银行', '中国渤海银行', '上海银行', '中国工商银行',
            '东亚银行', '上海农商银行', '中国建设银行', '中国兴业银行', '平安银行', '广发银行', '北京农商银行', '宁波银行',
            '光大银行', '北京银行', '大连银行', '尧都农商银行', '徽商银行', '华夏银行', '南京银行', '广州银行', '浙商银行',
            '招商银行', '民生银行', '汉口银行', '晋商银行', '杭州银行', '深圳发展银行', '江苏银行', '成都银行', '珠海农商银行',
            '顺德农村商业银行', '中国邮政银行', '银联通道'
        ],
        'MYR' => [
            '423', 'CIMB Clicks Bank', 'Hong Leong Bank', 'May Bank', 'Public Bank', 'RHB Bank'
        ],
        'THB' => [
            'Bangkok Bank', 'Kasikorn Bank', 'Krungsri (Bank of Ayudhya Public Company Limited)', 'Krung Thai Bank',
            'Siam Commercial Bank', 'UOBT'
        ],
        'IDR' => [
            'Bank Central Asia', 'Bank Rakyat Indonesia', 'Bank Negara Indonesia', 'BTN Bank', 'CIMB Clicks Indonesia',
            'Danamon Bank', 'Mandiri Bank', 'Permata Bank'
        ],
        'INR' => [
            'ABHYUDAYA COOP BANK', 'THE ROYAL BANK OF SCOTLAND', 'ABU DHABI COMMERCIAL BANK',
            'THE AKOLA DISTRICT CENTRAL COOPERATIVE BANK', 'AIRTEL PAYMENTS BANK LIMITED',
            'AKOLA JANATA COMMERCIAL COOPERATIVE BANK', 'ALLAHABAD BANK', 'THE AHMEDABAD MERC COOP BANK',
            'ANDHRA BANK', 'AUSTRALIA & NEW ZEALAND BANK', 'THE ANDHRA PRADESH STATE COOP BANK',
            'ANDHRA PRAGATI GRAMEEN BANK', 'THE A.P. MAHESH CO-OP URBAN BANK', 'APNA SAHAKARI BANK LTD',
            'ALMORA URBAN CO-OPERATIVE BANK LTD.', 'BASSEIN CATHOLIC CO-OP BANK', 'BANK OF BARODA', 'BARCLAYS BANK',
            'BANK OF BAHREIN & KUWAIT', 'THE BHARAT COOPERATIVE BANK', 'BANK OF CEYLON', 'BANDHAN BANK LIMITED',
            'DENA BANK', 'BANK OF INDIA', 'BHARATIYA MAHILA BANK LIMITED', 'B N PARIBAS BANK', 'BANK OF AMERICA',
            'BANK OF TOKYO-MITSUBISHI', 'CENTRAL BANK OF INDIA', 'CITIZEN CREDIT COOP BANK', 'JP MORGAN CHASE BANK',
            'CITI BANK', 'CITY UNION BANK', 'CAPITAL LOCAL AREA BANK LTD.', 'CANARA BANK', 'CORPORATION BANK',
            'THE COSMOS CO-OP. BANK', 'CREDIT SUISSE AG?', 'CREDIT AGRICOLE CORP N INVSMNT BK',
            'CHHATRAPATI RAJARSHISHAHU COOP BANK', 'CATHOLIC SYRIAN BANK', 'COMMONWEALTH BK OF AUSTRALIA',
            'CHINATRUST COMMERCIAL BANK', 'DEVELOPMENT BANK OF SINGAPORE', 'DEVELOPMENT CREDIT BANK',
            'DEOGIRI NAGARI SAHAKARI BANK LTD. AURANGABAD', 'DEUTSCHE BANK', 'DICGC',
            'THE DELHI STATE COOPERATIVE BANK LIMITED', 'DHANALAXMI BANK', 'DOMBIVLI NAGARI SAHAKARI BANK LTD',
            'DOHA BANK QSC', 'EXPORT IMPORT BANK OF INDIA', 'EQUITAS SMALL FINANCE BANK LIMITED', 'THE FEDERAL BANK',
            'FIRSTRAND BANK', 'THE GREATER BOMBAY CO-OP. BANK LTD',
            'THE GADCHIROLI DISTRICT CENTRAL COOPERATIVE BANK LIMITED', 'GURGAON GRAMIN BANK LTD.',
            'THE GUJARAT STATE CO-OPERATIVE BANK', 'THE HASTI COOP BANK LTD', 'HDFC BANK LTD.',
            'HIMACHAL PRADESH STATE COOPERATIVE BANK LTD', 'HONG KONG & SHANGHAI BANK', 'Woori',
            'PT BANK MAYBANK INDONESIA TBK', 'IDBI BANK', 'INDUSTRIAL BANK OF KOREA',
            'INDUSTRIAL AND COMMERCIAL BANK OF CHINA LIMITED', 'ICICI BANK LTD.', 'IDFC BANK LIMITED',
            'INDIAN BANK', 'IDUKKI DISTRICT CO OPERATIVE BANK LTD', 'INDUS-IND BANK', 'INDIAN OVERSEAS BANK',
            'THE JAMMU & KASHMIR BANK', 'JANSEVA SHAHKARI BANK LTD. PUNE', 'JANASEVA SAHAKARI BANK BORIVLI LIMITED',
            'JALGAON JANATA SAHAKARI', 'THE JALGAON PEOPELS COOPERATIVE BANK LIMITED', 'JANKALYAN SHAKARI BANK',
            'JANATA SAHAKARI BANK LTD (PUNE)', 'THE KANGRA CENTRAL COOPERATIVE BANK', 'KALLAPPANNA AWADE ICH JANATA S',
            'THE KANGRA COOPERATIVE BANK LTD', 'KARNATAKA BANK', 'KAPOLE BANK', 'THE KALUPUR COMM COOP BANK',
            'THE KALYAN JANATA SAHAKARI BANK', 'KOTAK MAHINDRA BANK', 'KERALA GRAMIN BANK',
            'THE KURMANCHAL NAGAR SAHAKARI BANK LIMITED', 'THE KARNATAKA STATE COOP APEX BANK', 'KEB Hana Bank',
            'THE KARAD URBAN COOP BANK LTD', 'KARUR VYSYA BANK', 'KARNATAKA GRAMIN VIKAS BANK',
            'THE LAKSHMI VILAS BANK', 'BANK OF MAHARASHTRA', 'Maharashtra Gramin Bank', 'MAHANAGAR COOP BANK',
            'MUMBAI DISTRICT CENTRAL CO-OP BANK', 'MIZUHO CORPORATE BANK LTD', 'Maharashtra State Cooperative Bank',
            'MASHREQ BANK', 'THE MEHSANA URBAN COOPERATIVE BANK', 'THE MUNICIPAL CO OPERATIVE BANK LTD',
            'NATIONAL AUSTRALIA BANK LIMITED', 'NATIONAL BANK OF ABU DHABI PJSC', 'NAGPUR NAGRIK (NNSB LTD*)',
            'NEW INDIA CO-OPERATIVE BANK', 'NKGSB BANK', 'THE NASIK MERCHANTS CO-OP BANK LTD.',
            'NORTH MALBAR GRAMIN BANK', 'NUTAN NAGARIK SAHAKARI BANK', 'THE BANK OF NOVA SCOTIA',
            'THE NAINITAL BANK LTD', 'NAGAR URBAN CO OPERATIVE BANK', 'OMAN INTERNATIONAL BANK',
            'ORIENTAL BANK OF COMMERCE', 'PARSIK JANATA SAHAKARI BANK', 'PRAGATHI KRISHNA GRAMIN BANK',
            'PUNJAB AND MAHARASHTRA CO-OP BANK', 'PRIME CO OPERATIVE BANK LTD', 'PRATHAMA BANK', 'PUNJAB AND SIND BANK',
            'THE PANDHARPUR URBAN CO OP. BANK LTD. PANDHARPUR', 'PUNJAB NATIONAL BANK', 'RABOBANK INTERNATIONAL (CCRB)',
            'THE RATNAKAR BANK', 'RESERVE BANK OF INDIA', 'RAJKOT NAGARIK SAHAKARI BANK LTD',
            'RAJGURUNAGAR SAHAKARI BANK LIMITED', 'THE RAJASTHAN STATE CO-OP BANK', 'SBERBANK',
            'SAHEBRAO DESHMUKH COOPERATIVE BANK LIMITED', 'STATE BANK OF BIKANER AND JAIPUR', 'STATE BANK OF HYDERABAD',
            'STATE BANK OF INDIA', 'STATE BANK OF MYSORE', 'SAMARTH SAHAKARI BANK LTD', 'STATE BANK OF TRAVANCORE',
            'STANDARD CHARTERED BANK', 'THE SURAT DISTRICT CO-OP BAN', 'SHINHAN BANK', 'SHIKSHAK SAHAKARI BANK LIMITED',
            'SOUTH INDIAN BANK', 'SOLAPUR JANATA SAHAKARI BANK LIMITED', 'SUMITOMO MITSUI BANKING CORPORATION',
            'SHIVALIK MERCANTILE CO OPERATIVE BANK LTD', 'SOCIETE GENERALE', 'THE SURAT PEOPLE?S CO-OP BANK',
            'THE SARASWAT CO-OPERATIVE BANK', 'STATE BANK OF PATIALA', 'STATE BANK OF MAURITIUS',
            'SURAT NATIONAL COOPERATIVE BANK LIMITED', 'THE SUTEX COOPERATIVE BANK',
            'THE SEVA VIKAS COOPERATIVE BANK LIMITED', 'THE SHAMRAO VITHAL COOP BANK', 'SYNDICATE BANK',
            'THANE BHARAT SAHAKARI BANK LTD', 'THE THANE DISTRICT CENTRAL COOPERATIVE BANK LIMITED',
            'TUMKUR GRAIN MERCHANTS CO-OP BANK', 'THE THANE JANATA SAHAKARI BANK', 'TAMILNADU MERC. BANK',
            'THE TAMILDADU STATE APEX COOP BANK', 'UNION BANK OF INDIA', 'UBS AG', 'UCO BANK',
            'UNITED OVERSEAS BANK LIMITED', 'UNITED BANK OF INDIA', 'AXIS BANK', 'THE VARACHHA CO-OP. BANK LTD.',
            'VIJAYA BANK', 'THE VISHWESHWAR SAHAKARI BANK LTD', 'VASAI VIKAS SAHAKARI BANK', 'ING VYSYA BANK',
            'THE WEST BENGAL STATE CO-OP BANK', 'WESTPAC BANKING CORPORATION', 'YES BANK',
            'THE ZOROASTRIAN COOPERATIVE BANK LIMITED', 'ZILA SAHAKRI BANK LIMITED GHAZIABAD'
        ],
        'ARS' => [
            'A.B.N Amro Bank', 'Banco de Galicia Y Buenos Aires', 'Lloyds Tsb Bank', 'Banco de La Nacion Argentina',
            'Banco de La Provincia de Buenos A', 'Bankboston, National Associa', 'Citibank', 'BBVA Banco Frances',
            'The Bank Of Tokyo - Mitsubishi', 'Banco de La Provincia de Cordoba', 'Banco Societe Generale',
            'Banco de La Ciudad de Buenos Aires', 'Banco Patagonia Sudameris', 'Banco Hipotecario', 'Banco de San Juan',
            'Banco Do Brasil', 'Banco Del Tucuman', 'Banco Municipal de Ros', 'Banco Rio de La Plata',
            'Banco Regional de Cuyo', 'Banco Del Chubut', 'Banco de Santa Cruz',
            'Banco de La Pampa Sociedad de Economia M', 'Banco de Corrientes', 'Banco Provincia Del Neuquen',
            'Banco Empresario de Tucuman Coop. L', 'Banco B. I. Creditanstalt', 'HSBC Bank Argentina',
            'J P Morgan Chase Bank Sucursal Buenos Aires', 'Banco Credicoop Coop. L', 'Banco de Valores', 'Banco Roela',
            'Banco Mariva', 'Banco Itau Buen Ayre', 'Bank Of America, National Associa', 'Banca Nazionale Del Lavoro',
            'Bnp Paribas', 'Banco Provincia de Tierra Del Fuego', 'Banco de La Republica Oriental Del Uruguay',
            'Banco Saenz', 'Banco Meridian', 'Banco Macro Bansud', 'Banco Mercurio', 'Ing Bank',
            'American Express Bank Ltd', 'Banco Banex', 'Banco Comafi', 'Banco de Inversion Y Comercio Exterior',
            'Banco Piano', 'Banco Finansur', 'Banco Julio', 'Banco Privado de Inversiones', 'Nuevo Banco de La Rioja',
            'Banco Del Sol', 'Nuevo Banco Del Chaco', 'M. B. A. Banco de Inversiones', 'Banco de Formosa', 'Banco CMF',
            'Banco de Santiago Del Estero', 'Nuevo Banco Industrial de Azul', 'Deutsche Bank',
            'Nuevo Banco de Santa Fe', 'Banco Cetelem Argentina', 'Banco de Servicios Financieros', 'Banco Cofidis',
            'Banco Bradesco Argentina', 'Banco de Servicios Y Transacciones', 'Rci Ba',
            'Bacs Banco de Credito Y Securitizacion', 'Nuevo Banco de Entre Rios', 'Nuevo Banco Suquia',
            'Nuevo Banco Bisel', 'Banco Columbia'
        ],
        'BRL' => [
            'BANCO DO BRASIL S.A.', 'BANCO DA AMAZONIA S.A.', 'BANCO DO NORDESTE DO BRASIL S.A.',
            'BANESTES S.A. BANCO DO ESTADO DO ESPIRITO SANTO', 'BANCO SANTANDER BRASIL S.A.',
            'BANCO DO ESTADO DO PARA S.A. - BANPARA', 'BANCO DO ESTADO DO RIO GRANDE DO SUL S.A. - BANRISUL',
            'BANCO DO ESTADO DE SERGIPE S.A. - BANESE', 'BANCO DE BRASILIA S.A. - BRB', 'CAIXA ECONOMICA FEDERAL - CEF',
            'BANCO BONSUCESSO S.A.', 'BANCO BRADESCO S.A.', 'BANCO ABC BRASIL S.A.', 'ITAU UNIBANCO S.A.',
            'BANCO MERCANTIL DO BRASIL S.A.', 'HSBC BANK BRASIL S.A. - BANCO MULTIPLO', 'BANCO SAFRA S.A.',
            'CITIBANK N.A.', 'BANCO DAYCOVAL S.A.', 'BANCO MODAL S.A.', 'BANCO COOPERATIVO SICREDI S.A.',
            'BANCO COOPERATIVO DO BRASIL S/A - BANCOOB'
        ],
        'CLP' => [
            'Banco de Chile', 'Banco Internacional', 'Banco del Estado de Chile', 'Scotiabank Chile',
            'Banco Crédito e Inversiones', 'Banco Bice', 'HSBC Bank', 'Banco Santander- Santiago', 'Itau Corpbanca',
            'ABN Amro Bank Chile', 'Banco Security', 'Banco Falabella', 'Deutsche Bank', 'Banco Ripley',
            'Rabobank Chile', 'Banco Consorcio', 'Banco Penta', 'BBVA Chile', 'Banco del Desarrollo'
        ],
        'COP' => [
            'BANCO DE BOGOTA', 'BANCO POPULAR', 'CORPBANCA', 'BANCOLOMBIA', 'CITIBANK', 'HSBC', 'BANCO SUDAMERIS',
            'BBVA', 'HELM BANK S.A', 'BANCO COLPATRIA', 'BANCO DE OCCIDENTE', 'BANCO CAJA SOCIAL BCSC', 'BANCO AGRARIO',
            'BANCO DAVIVIENDA', 'BANCO AV VILLAS', 'BANCO PROCREDIT', 'BANCO PICHINCHA', 'BANCOOMEVA',
            'BANCO FALABELLA S.A', 'COOPCENTRAL S.A', 'COOPERATIVA FINANCIERA DE ANTIOQUIA',
            'COTRAFA COOPERATIVA FINANCIERA', 'CONFIAR', 'FINANCIERA JURISCOOP'
        ],
        'MXN' => [
            'BANAMEX', 'BANCOMEXT', 'BANOBRAS', 'BBVA BANCOMER', 'SANTANDER', 'BANJERCITO', 'HSBC', 'BAJIO', 'IXE',
            'INBURSA', 'INTERACCIONES', 'MIFEL', 'SCOTIABANK', 'BANREGIO', 'INVEX', 'BANSI', 'AFIRME', 'BANORTE',
            'THE ROYAL BANK', 'AMERICAN EXPRESS', 'BAMSA', 'TOKYO', 'JP MORGAN', 'BMONEX', 'VE POR MAS', 'ING',
            'DEUTSCHE', 'CREDIT SUISSE', 'AZTECA', 'AUTOFIN', 'BARCLAYS', 'COMPARTAMOS', 'BANCO FAMSA', 'BMULTIVA',
            'ACTINVER', 'WALMART', 'NAFIN', 'INTERBANCO', 'BANCOPPEL', 'ABC CAPITAL', 'UBS BANK', 'CONSUBANCO',
            'VOLKSWAGEN', 'CIBANCO', 'BBASE', 'BANSEFI', 'HIPOTECARIA FEDERAL', 'MONEXCB', 'GBM', 'MASARI', 'VALUE',
            'ESTRUCTURADORES', 'TIBER', 'VECTOR', 'B&B', 'ACCIVAL', 'MERRILL LYNCH', 'FINAMEX', 'VALMEX', 'UNICA',
            'MAPFRE', 'PROFUTURO', 'CB ACTINVER', 'OACTIN', 'SKANDIA', 'CBDEUTSCHE', 'ZURICH', 'ZURICHVI', 'SU CASITA',
            'CB INTERCAM', 'CI BOLSA', 'BULLTICK CB', 'STERLING', 'FINCOMUN', 'HDI SEGUROS', 'ORDER', 'AKALA',
            'CB JPMORGAN', 'REFORMA', 'STP', 'TELECOMM', 'EVERCORE', 'SKANDIA', 'SEGMTY', 'ASEA', 'KUSPIT',
            'SOFIEXPRESS', 'UNAGRA', 'OPCIONES EMPRESARIALES DEL NOROESTE', 'LIBERTAD', 'CLS', 'INDEVAL'
        ],
        'PEN' => [
            'Banco Central de Reserva', 'Banco de Crédito del Perú', 'Interbank', 'Citibank', 'Scotiabank',
            'BBVA Continental', 'Banco de la Nación', 'Banco de Comercio', 'Banco Financiero',
            'Banco Interamericano de Finanzas (BIF)', 'Crediscotia Financiera', 'Mi Banco', 'Banco GNB Perú S.A.',
            'Banco Falabella', 'Santander', 'Caja Metropolitana de Lima',
            'Caja Municipal de Ahorro y Crédito Piura SAC', 'Caja Municipal de Ahorro y Crédito Trujillo',
            'Caja Municipal de Ahorro y Crédito Arequipa', 'Caja Municipal de Ahorro y Crédito Sullana',
            'Caja Municipal de Ahorro y Crédito Cuzco', 'Caja Municipal de Ahorro y Crédito Huancayo'
        ],
        'UYU' => [
            'BROU - Banco de la República Oriental del Uruguay', 'Banco Hipotecario del Uruguay', 'Banco Bandes',
            'Banco ITAU', 'Scotiabank', 'Banco Santander', 'Banco Bilbao Vizcaya Argentaria', 'HSBC Bank',
            'Banque Heritage', 'Citibank N.A. Sucursal', 'Banco de la Nación Argentina'
        ]
    ];

    /**
     * Get allowed Bank Names per Currency
     *
     * @param $currency
     * @return array
     */
    public static function getBankNamesPerCurrency($currency)
    {
        $currency = strtoupper($currency);

        if (array_key_exists($currency, self::$names)) {
            return self::$names[$currency];
        }

        return [];
    }

    /**
     * Get allowed currencies for OnlineBanking\Payout
     *
     * @return array
     */
    public static function getAllowedCurrencies()
    {
        return Common::getArrayKeys(self::$names);
    }
}

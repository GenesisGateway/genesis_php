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
            'THE ZOROASTRIAN COOPERATIVE BANK LIMITED', 'ZILA SAHAKRI BANK LIMITED GHAZIABAD',
            'Paytm Payments Bank Ltd.'
        ],
        'ARS' => [
            'CVU Account', 'Banco de Galicia Y Buenos Aires', 'Banco de La Nacion Argentina',
            'Banco de La Provincia de Buenos Aires', 'Industrial and Commercial Bank of China (ICBC) Argentina',
            'BBVA', 'Banco de La Provincia de Cordoba', 'Banco Supervielle S.A.', 'Banco de La Ciudad de Buenos Aires',
            'Banco Patagonia Sudameris', 'Banco Hipotecario', 'Banco de San Juan', 'Banco Municipal de Rosario',
            'Banco Santander', 'Banco Del Chubut', 'Banco de Santa Cruz', 'Banco de La Pampa Sociedad de Economia M',
            'Banco de Corrientes', 'Banco Provincia Del Neuquen', 'Brubank S.A.U.', 'Banco B. I. Creditanstalt',
            'HSBC Bank Argentina', 'J P Morgan Chase Bank Sucursal Buenos Aires', 'Banco Credicoop Coop. L',
            'Banco de Valores', 'Banco Roela', 'Banco Mariva', 'Banco Itau', 'Bank Of America, National Associa',
            'Bnp Paribas', 'Banco Provincia de Tierra Del Fuego', 'Banco de La Republica Oriental Del Uruguay',
            'Banco Saenz', 'Banco Meridian', 'Banco Macro', 'Banco Comafi', 'Banco de Inversion Y Comercio Exterior',
            'Banco Piano', 'Banco Julio', 'Nuevo Banco de La Rioja', 'Banco Del Sol', 'Nuevo Banco Del Chaco',
            'BANCO VOII S.A.', 'Banco de Formosa', 'Banco CMF', 'Banco de Santiago Del Estero',
            'Nuevo Banco Industrial de Azul', 'Deutsche Bank', 'Nuevo Banco de Santa Fe', 'Banco Cetelem Argentina',
            'Banco de Servicios Financieros', 'Banco Cofidis', 'Banco Bradesco Argentina',
            'Banco de Servicios Y Transacciones', 'RCI Banque Argentina', 'Bacs Banco de Credito Y Securitizacion',
            'Banco Mas Ventas', 'Wilobank S.A.', 'Nuevo Banco Bisel', 'Banco Columbia', 'Banco Bica S.A.',
            'Banco Coinag S.A.', 'Banco de Comercio S.A.', 'Banco Sucredito Regional S.A.U.', 'Banco Dino S.A.',
            'Bank of Chine Limited Sucursal Buenos Aires'
        ],
        'BRL' => [
            'Banco do Brasil S.A.', 'Banco da Amazonia S.A.', 'Banco do Nordeste do Brasil S.A.',
            'BANCO NACIONAL DE DESENVOLVIMENTO ECONOMICO E SOCIAL', 'CREDICOAMO CREDITO RURAL COOPERATIVA',
            'CREDIT SUISSE HEDGING-GRIFFO CORRETORA DE VALORES S.A', 'Banco Inbursa S.A.',
            'STATE STREET BRASIL S.A. – BANCO COMERCIAL',
            'UBS Brasil Corretora de Câmbio Títulos e Valores Mobiliários S.A.', 'BNY Mellon Banco S.A.',
            'Banco Tricury S.A.', 'Banestes S.A. Banco do Estado do Espirito Santo', 'Banco Bandepe S.A.',
            'Banco Alfa S.A.', 'Banco Itaú Consignado S.A.', 'Banco Santander Brasil S.A.', 'Banco Bradesco BBI S.A.',
            'Banco do Estado do Para S.A. - BANPARA', 'Banco Cargill S.A.',
            'Banco do Estado do Rio Grande do Sul S.A. - BANRISUL', 'Banco do Estado de Sergipe S.A. - BANESE',
            'Hipercard Banco Múltiplo S.A.', 'Banco Bradescard S.A.', 'GOLDMAN SACHS DO BRASIL BANCO MULTIPLO S.A.',
            'Banco AndBank (Brasil) S.A.', 'BANCO MORGAN STANLEY S.A.', 'Banco Crefisa S.A.',
            'Banco de Brasilia S.A. - BRB', 'Banco J. Safra S.A.', 'Banco ABN Amro S.A.', 'Banco KDB do Brasil S.A.',
            'Banco Inter', 'Haitong Banco de Investimento do Brasil S.A.', 'Banco Original do Agronegócio S.A.',
            'BancoSeguro S.A.', 'BANCO TOPÁZIO S.A.', 'Banco da China Brasil S.A.', 'Unicred Norte do Parana',
            'Cooperativa Central de Credito Urbano - CECRED', 'Banco Finaxis S.A.', 'Travelex Banco de Câmbio S.A.',
            'Banco B3 S.A.', 'Caixa Economica Federal - CEF', 'Banco Bocom BBM S.A.',
            'Banco Western Union do Brasil S.A.', 'BANCO RODOBENS S.A.', 'Banco Agiplan S.A.',
            'Banco Bradesco BERJ S.A.', 'Banco Woori Bank do Brasil S.A.', 'Plural S.A. Banco Múltiplo',
            'BR Partners Banco de Investimento S.A.', 'MS Bank S.A. Banco de Câmbio',
            'UBS Brasil Banco de Investimento S.A.', 'ICBC do Brasil Banco Múltiplo S.A.',
            'Confederacao Nacional das Cooperativas Centrais Unicreds', 'Intesa Sanpaolo Brasil S.A. - Banco Múltiplo',
            'BEXS BANCO DE CÂMBIO S/A', 'Commerzbank Brasil S.A. - Banco Múltiplo',
            'Banco Olé Bonsucesso Consignado S.A.', 'Banco Itaú BBA S.A.', 'Stone Pagamentos S.A.',
            'Banco BTG Pactual S.A.', 'Banco Original', 'Banco Arbi S.A.', 'Banco John Deere S.A.',
            'Banco Bonsucesso S.A.', 'BANCO CRÉDIT AGRICOLE BRASIL S.A.', 'Banco Fibra S.A.', 'Banco Cifra S.A.',
            'Banco Bradesco S.A.', 'BANCO CLASSICO S.A.', 'Banco Máxima S.A.', 'Banco ABC Brasil S.A.',
            'Banco Investcred Unibanco S.A.', 'BCV - BANCO DE CRÉDITO E VAREJO S.A.', 'Bexs Corretora de Câmbio S/A',
            'PARANÁ BANCO S.A.', 'MONEYCORP BANCO DE CÂMBIO S.A.', 'Nu Pagamentos (Nubank)', 'Banco Fator S.A.',
            'BANCO CEDULA S.A.', 'HSBC BRASIL S.A. - BANCO DE INVESTIMENTO', 'Pagseguro Internet S.A',
            'Banco de la Nacion Argentina', 'BPP Instituição de Pagamento S.A.', 'Banco Bmg S.A.',
            'China Construction Bank (Brasil) Banco Múltiplo S/A', 'Mercadopago.com Representacoes LTDA',
            'BANCO BARI DE INVESTIMENTOS E FINANCIAMENTOS S.A.', 'Banco Digio S.A.', 'Banco C6 S.A.',
            'Itau Unibanco S.A.', 'Banco XP S.A.', 'BANCO SOCIETE GENERALE BRASIL S.A.', 'Banco Mizuho do Brasil S.A.',
            'BANCO J.P. MORGAN S.A.', 'Banco Mercantil do Brasil S.A.', 'Banco Bradesco Financiamentos S.A.',
            'Kirton Bank S.A. - Banco Multiplo', 'CORA SCD S.A.', 'BANCO CAPITAL S.A.', 'Banco Safra S.A.',
            'Banco MUFG Brasil S.A.', 'Banco Sumitomo Mitsui Brasileiro S.A.', 'Banco Caixa Geral - Brasil S.A.',
            'Citibank N.A.', 'Banco ItauBank S.A.', 'DEUTSCHE BANK S.A. - BANCO ALEMAO',
            'JPMorgan Chase Bank National Association', 'ING Bank N.V.', 'Banco Credit Suisse (Brasil) S.A.',
            'Banco Luso Brasileiro S.A.', 'Banco Industrial do Brasil S.A.', 'Banco VR S.A.', 'Banco Paulista S.A.',
            'Banco Guanabara S.A.', 'Omni Banco S.A.', 'Banco Panamericano S.A.', 'BANCO FICSA S.A.',
            'Banco Smartbank S.A.', 'Banco Rendimento S.A.', 'Banco Sofisa', 'BANCO TRIANGULO S.A.', 'Banco Pine S.A.',
            'Itaú Unibanco Holding S.A.', 'BANCO INDUSVAL S.A.', 'BANCO A.J. RENNER S.A.',
            'Banco Votorantim S.A. (Banco Neon)', 'Banco Daycoval S.A.', 'Banco Ourinvest S.A.', 'Banco Cetelem S.A.',
            'BANCO RIBEIRAO PRETO S.A.', 'Banco Semear S.A.', 'Banco Citibank', 'Banco Modal S.A.',
            'Banco Rabobank International Brasil S.A.', 'Banco Cooperativo Sicredi S.A.',
            'Scotiabank Brasil S.A. Banco Múltiplo', 'Banco BNP Paribas Brasil S.A.',
            'Novo Banco Continental S.A. - Banco Múltiplo', 'Banco Sistema S.A.',
            'Bank of America Merrill Lynch Banco Múltiplo S.A.', 'Banco Cooperativo do Brasil S.A. - BANCOOB',
            'BANCO KEB HANA DO BRASIL S.A.', 'BANK A.J. RENNER S.A.', 'BANK ABC BRAZIL S.A.', 'BANK ABN AMRO S.A.',
            'ALFA BANK S.A.', 'ALVORADA BANK S.A.', 'BANCO ARBI S.A.', 'AZTECA BANK OF BRAZIL S.A.',
            'BANE BANDEPE S.A.', 'BARCLAYS BANK S.A.', 'BANK BBM S / A',
            'BM & FBOVESPA BANK OF SETTLEMENT AND CUSTODY SERVICES S.A.', 'BMG BANK S.A.',
            'BNCO BNP PARIBAS BRAZIL S.A.', 'INTERATLANTIC BOAVISTA BENCH S.A.', 'BANCO BONSUCESSO S.A.',
            'BRADESCARD BANK S.A.', 'BRADESCO BANK BBI S.A.', 'BRADESCO BENCH BERJ S.A.', 'BRADESCO BANK CARDS S.A.',
            'BANCO BRADESCO FINANCING S.A.', 'BANCO BRADESCO S.A.', 'BTG PACTUAL BANK S.A.', 'BANCO CACIQUE S.A.',
            'GENERAL BOX BANK â€“ BRAZIL S.A.', 'CAPITAL BANK S.A.', 'CARGILL S.A. BANK', 'CEDULA BANK S.A.',
            'CETELEM BANK S.A.', 'BANCO CIFRA S.A.', 'CITIBANK S.A.', 'CLASSIC BANK S.A.',
            'CNH INDUSTRIAL CAPITAL S.A.', 'CONFIDENCE BANK EXCHANGE S.A.',
            'COOPERATIVE BANK OF BRAZIL S.A. â€“ BANCOOB', 'Cooperative Bench SICREDI S.A.',
            'CREDIT BANK AGRICOLE BRAZIL S.A.', 'CREDIT SUISSE BANK (BRAZIL) S.A.', 'BANK OF AMAZONIA S.A.',
            'CHINA BRAZIL S.A. BANK', 'DAYCOVAL BANK S.A.', 'BANK OF LA NATIONAL ARGENTINA',
            'BANK OF LA PROVINCE OF BUENOS AIRES', 'BANK OF LA ORIENTAL REPUBLIC OF URUGUAY',
            'LAGE BANK LANDEN BRAZIL S.A.', 'TOKYO-MITSUBISHI BANK UFJ BRASIL S.A.', 'BANK OF BRAZIL S.A.',
            'SERGIPE S.A. STATE BANK', 'PARÃ S.A. STATE BANK', 'BANK OF THE STATE OF RIO GRANDE DO SUL S.A.',
            'BANK OF THE NORTHEAST OF BRAZIL S.A.', 'FACTOR BANK S.A.', 'FIBER BENCH S.A.', 'BANCO FICSA S.A.',
            'BANK FORD S.A.', 'BANK GENERATOR S.A.', 'GMAC BANK S.A.', 'BANCO GUANABARA S.A.', 'BANCO HONDA S.A.',
            'BANK IBM S.A.', 'INDUSTRIAL BANK OF BRAZIL S.A.', 'INDUSTRIAL AND COMMERCIAL BANK S.A.',
            'INDUSVAL BANK S.A.', 'INTERCAP BANK S.A.', 'INTERMEDIUM BANK S.A.', 'BANK INVESTCRED UNIBANCO S.A.',
            'ITAÃš BANK BBA S.A.', 'BANK ITAÃš BMG CONSIGNADO S.A.', 'ITAUBANK BANK S.A.', 'BANK J. SAFRA S.A.',
            'BANK J.P. MORGAN S.A.', 'BANK JOHN DEERE S.A.', 'KDB BANK OF BRAZIL S.A.', 'BANK KEB OF BRAZIL S.A.',
            'BRAZILIAN LUSO BANK S.A.', 'MAXIMUM BANK S.A.', 'MAXINVEST BANK S.A.', 'BRAZIL\'S BANK',
            'BANCO MIZUHO OF BRAZIL S.A.', 'MODAL BENCH S.A.', 'BANCO MONEO S.A.', 'BANCO MORGAN STANLEY S.A.',
            'ORIGINAL AGRIBUSINESS BANK S.A.', 'ORIGINAL BANK S.A.', 'OURINVEST BANK S.A.', 'PAN S.A.',
            'BANCO PAULISTA S.A.', 'BANCO PECUNIA S.A.', 'BANK PETRA S.A.', 'BANK PINE S.A.', 'POTTENTIAL BANK S.A.',
            'BANCO PSA FINANCE BRASIL S.A.', 'BANCO RABOBANK INTERNATIONAL BRASIL S.A.', 'BAND RANDON S.A.',
            'BANK INCOME S.A.', 'BANCO RIBEIRAO BLACK S.A.', 'BANCO RODOBENS S.A.', 'SAFRA BANK S.A.',
            'SEMEAR BANK S.A.', 'BANK SYSTEM S.A.', 'BANK SOCIETE GENERALE BRAZIL S.A.', 'SOFISA BANK S.A.',
            'SUMITOMO BANK MITSUI BRAZILIAN S.A.', 'BANK TOPÃZIO S.A.', 'TOYOTA BANK OF BRAZIL S.A.',
            'BANCO TRIANGULO S.A.', 'BANCO TRICURY S.A.', 'VOLKSWAGEN BANK S.A.', 'BANK VOLVO BRAZIL S.A.',
            'VOTORANTIM S.A.', 'BANK VR S.A.', 'WESTERN UNION BANK OF BRAZIL S.A.', 'WOORI BANK FROM BRAZIL S.A.',
            'BANESTES S.A. BANK OF THE STATE OF ESPIRITO SANTO', 'BANIF â€“ FUNCHAL INTERNATIONAL BANK (BRAZIL), S.A.',
            'BANK OF AMERICA MERRILL LYNCH MULTIPLE BANK S.A.', 'BBN BRAZILIAN BUSINESS BANK S.A.',
            'BCV â€“ CREDIT BANK AND RETAIL S / A', 'BNY MELLON BANCO S.A.', 'BPN BRASIL MULTIPLE BANK S.A.',
            'BRAZIL PLURAL S.A. MULTIPLE BANK', 'BRB â€“ BANCO DE BRASILIA S.A.', 'CITIBANK N.A.',
            'DEUTSCHE BANK S.A. â€“ GERMAN BANK', 'GOLDMAN SACHS FROM BRAZIL BANCO MULTIPLO S.A.',
            'HIPERCARD MULTIPLE BANK S.A.', 'ICBC BRAZIL MULTIPLE BANK S.A.', 'ING BANK N.V.',
            'ITAÃš UNIBANCO HOLDING S.A.', 'ITAÃš UNIBANCO S.A.', 'JPMORGAN CHASE BANK, NATIONAL ASSOCIATION',
            'NATIXIS BRAZIL S.A. MULTIPLE BANK', 'NEW CONTINENTAL BANK S.A. â€“ MULTIPLE BANK', 'PARANÃ BANCO S.A.',
            'SCOTIABANK BRASIL S.A. MULTIPLE BANK',
        ],
        'CAD' => [
            'Interac e-Transfer Outbound Pay-out', 'eCashout Pay-out'
        ],
        'CLP' => [
            'Banco de Chile', 'Banco Internacional', 'Banco del Estado de Chile', 'Scotiabank Chile',
            'Banco Crédito e Inversiones', 'Banco Bice', 'HSBC Bank', 'Banco Santander- Santiago', 'Itau Corpbanca',
            'Banco Security', 'Banco Falabella', 'Banco Ripley', 'Banco Consorcio', 'BBVA Chile',
            'Banco del Desarrollo', 'Coopeuch', 'Prepago los Héroes', 'Tenpo Prepago'
        ],
        'COP' => [
            'BANCO DE BOGOTA', 'BANCO POPULAR', 'BANCO SANTANDER', 'BANCOLOMBIA', 'HSBC', 'BANCO SUDAMERIS', 'BBVA',
            'ITAU', 'BANCO COLPATRIA', 'BANCO DE OCCIDENTE', 'BANCOLDEX S.A.', 'BANCO CAJA SOCIAL BCSC',
            'BANCO AGRARIO', 'BANCO MUNDO MUJER', 'BANCO DAVIVIENDA', 'BANCO AV VILLAS', 'BANCO W S.A',
            'BANCO PROCREDIT', 'BANCAMIA S.A', 'BANCO PICHINCHA', 'BANCOOMEVA', 'BANCO FALABELLA S.A',
            'BANCO FINANDINA S.A.', 'BANCO MULTIBANK S.A.', 'BANCO SERFINANZA S.A.', 'COOPCENTRAL S.A',
            'COOPERATIVA FINANCIERA DE ANTIOQUIA', 'COTRAFA COOPERATIVA FINANCIERA', 'CONFIAR', 'FINANCIERA JURISCOOP',
            'COLTEFINANCIERA S.A.', 'NEQUI'
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
            'Caja Municipal de Ahorro y Crédito Cuzco', 'Caja Municipal de Ahorro y Crédito Huancayo',
            'Caja Municipal de Ahorro y Crédito Tacna'
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

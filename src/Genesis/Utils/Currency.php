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
namespace Genesis\Utils;

/**
 * Currency-related methods
 *
 * @package Genesis\Utils
 */
final class Currency
{
    /**
     * List of currencies, defined by ISO-4217
     *
     * @var array
     */
    public static $iso4217
        = array(
            'AED' => array(
                'name'        => 'UAE Dirham',
                'code'        => '784',
                'country'     => 'UNITED ARAB EMIRATES (THE)',
                'exponent'    => '2'
            ),
            'AFN' => array(
                'name'        => 'Afghani',
                'code'        => '971',
                'country'     => 'AFGHANISTAN',
                'exponent'    => '2'
            ),
            'ALL' => array(
                'name'        => 'Lek',
                'code'        => '008',
                'country'     => 'ALBANIA',
                'exponent'    => '2'
            ),
            'AMD' => array(
                'name'        => 'Armenian Dram',
                'code'        => '051',
                'country'     => 'ARMENIA',
                'exponent'    => '2'
            ),
            'ANG' => array(
                'name'        => 'Netherlands Antillean Guilder',
                'code'        => '532',
                'country'     => 'SINT MAARTEN (DUTCH PART)',
                'exponent'    => '2'
            ),
            'AOA' => array(
                'name'        => 'Kwanza',
                'code'        => '973',
                'country'     => 'ANGOLA',
                'exponent'    => '2'
            ),
            'ARS' => array(
                'name'        => 'Argentine Peso',
                'code'        => '032',
                'country'     => 'ARGENTINA',
                'exponent'    => '2'
            ),
            'AUD' => array(
                'name'        => 'Australian Dollar',
                'code'        => '036',
                'country'     => 'TUVALU',
                'exponent'    => '2'
            ),
            'AWG' => array(
                'name'        => 'Aruban Florin',
                'code'        => '533',
                'country'     => 'ARUBA',
                'exponent'    => '2'
            ),
            'AZN' => array(
                'name'        => 'Azerbaijanian Manat',
                'code'        => '944',
                'country'     => 'AZERBAIJAN',
                'exponent'    => '2'
            ),
            'BAM' => array(
                'name'        => 'Convertible Mark',
                'code'        => '977',
                'country'     => 'BOSNIA AND HERZEGOVINA',
                'exponent'    => '2'
            ),
            'BBD' => array(
                'name'        => 'Barbados Dollar',
                'code'        => '052',
                'country'     => 'BARBADOS',
                'exponent'    => '2'
            ),
            'BDT' => array(
                'name'        => 'Taka',
                'code'        => '050',
                'country'     => 'BANGLADESH',
                'exponent'    => '2'
            ),
            'BGN' => array(
                'name'        => 'Bulgarian Lev',
                'code'        => '975',
                'country'     => 'BULGARIA',
                'exponent'    => '2'
            ),
            'BHD' => array(
                'name'        => 'Bahraini Dinar',
                'code'        => '048',
                'country'     => 'BAHRAIN',
                'exponent'    => '3'
            ),
            'BIF' => array(
                'name'        => 'Burundi Franc',
                'code'        => '108',
                'country'     => 'BURUNDI',
                'exponent'    => '0'
            ),
            'BMD' => array(
                'name'        => 'Bermudian Dollar',
                'code'        => '060',
                'country'     => 'BERMUDA',
                'exponent'    => '2'
            ),
            'BND' => array(
                'name'        => 'Brunei Dollar',
                'code'        => '096',
                'country'     => 'BRUNEI DARUSSALAM',
                'exponent'    => '2'
            ),
            'BOB' => array(
                'name'        => 'Boliviano',
                'code'        => '068',
                'country'     => 'BOLIVIA (PLURINATIONAL STATE OF)',
                'exponent'    => '2'
            ),
            'BOV' => array(
                'name'        => 'Mvdol',
                'code'        => '984',
                'country'     => 'BOLIVIA (PLURINATIONAL STATE OF)',
                'exponent'    => '2'
            ),
            'BRL' => array(
                'name'        => 'Brazilian Real',
                'code'        => '986',
                'country'     => 'BRAZIL',
                'exponent'    => '2'
            ),
            'BSD' => array(
                'name'        => 'Bahamian Dollar',
                'code'        => '044',
                'country'     => 'BAHAMAS (THE)',
                'exponent'    => '2'
            ),
            'BTN' => array(
                'name'        => 'Ngultrum',
                'code'        => '064',
                'country'     => 'BHUTAN',
                'exponent'    => '2'
            ),
            'BWP' => array(
                'name'        => 'Pula',
                'code'        => '072',
                'country'     => 'BOTSWANA',
                'exponent'    => '2'
            ),
            'BYR' => array(
                'name'        => 'Belarussian Ruble',
                'code'        => '974',
                'country'     => 'BELARUS',
                'exponent'    => '0'
            ),
            'BZD' => array(
                'name'        => 'Belize Dollar',
                'code'        => '084',
                'country'     => 'BELIZE',
                'exponent'    => '2'
            ),
            'CAD' => array(
                'name'        => 'Canadian Dollar',
                'code'        => '124',
                'country'     => 'CANADA',
                'exponent'    => '2'
            ),
            'CDF' => array(
                'name'        => 'Congolese Franc',
                'code'        => '976',
                'country'     => 'CONGO (THE DEMOCRATIC REPUBLIC OF THE)',
                'exponent'    => '2'
            ),
            'CHE' => array(
                'name'        => 'WIR Euro',
                'code'        => '947',
                'country'     => 'SWITZERLAND',
                'exponent'    => '2'
            ),
            'CHF' => array(
                'name'        => 'Swiss Franc',
                'code'        => '756',
                'country'     => 'SWITZERLAND',
                'exponent'    => '2'
            ),
            'CHW' => array(
                'name'        => 'WIR Franc',
                'code'        => '948',
                'country'     => 'SWITZERLAND',
                'exponent'    => '2'
            ),
            'CLF' => array(
                'name'        => 'Unidad de Fomento',
                'code'        => '990',
                'country'     => 'CHILE',
                'exponent'    => '4'
            ),
            'CLP' => array(
                'name'        => 'Chilean Peso',
                'code'        => '152',
                'country'     => 'CHILE',
                'exponent'    => '0'
            ),
            'CNY' => array(
                'name'        => 'Yuan Renminbi',
                'code'        => '156',
                'country'     => 'CHINA',
                'exponent'    => '2'
            ),
            'COP' => array(
                'name'        => 'Colombian Peso',
                'code'        => '170',
                'country'     => 'COLOMBIA',
                'exponent'    => '2'
            ),
            'COU' => array(
                'name'        => 'Unidad de Valor Real',
                'code'        => '970',
                'country'     => 'COLOMBIA',
                'exponent'    => '2'
            ),
            'CRC' => array(
                'name'        => 'Costa Rican Colon',
                'code'        => '188',
                'country'     => 'COSTA RICA',
                'exponent'    => '2'
            ),
            'CUC' => array(
                'name'        => 'Peso Convertible',
                'code'        => '931',
                'country'     => 'CUBA',
                'exponent'    => '2'
            ),
            'CUP' => array(
                'name'        => 'Cuban Peso',
                'code'        => '192',
                'country'     => 'CUBA',
                'exponent'    => '2'
            ),
            'CVE' => array(
                'name'        => 'Cabo Verde Escudo',
                'code'        => '132',
                'country'     => 'CABO VERDE',
                'exponent'    => '2'
            ),
            'CZK' => array(
                'name'        => 'Czech Koruna',
                'code'        => '203',
                'country'     => 'CZECH REPUBLIC (THE)',
                'exponent'    => '2'
            ),
            'DJF' => array(
                'name'        => 'Djibouti Franc',
                'code'        => '262',
                'country'     => 'DJIBOUTI',
                'exponent'    => '0'
            ),
            'DKK' => array(
                'name'        => 'Danish Krone',
                'code'        => '208',
                'country'     => 'GREENLAND',
                'exponent'    => '2'
            ),
            'DOP' => array(
                'name'        => 'Dominican Peso',
                'code'        => '214',
                'country'     => 'DOMINICAN REPUBLIC (THE)',
                'exponent'    => '2'
            ),
            'DZD' => array(
                'name'        => 'Algerian Dinar',
                'code'        => '012',
                'country'     => 'ALGERIA',
                'exponent'    => '2'
            ),
            'EGP' => array(
                'name'        => 'Egyptian Pound',
                'code'        => '818',
                'country'     => 'EGYPT',
                'exponent'    => '2'
            ),
            'ERN' => array(
                'name'        => 'Nakfa',
                'code'        => '232',
                'country'     => 'ERITREA',
                'exponent'    => '2'
            ),
            'ETB' => array(
                'name'        => 'Ethiopian Birr',
                'code'        => '230',
                'country'     => 'ETHIOPIA',
                'exponent'    => '2'
            ),
            'EUR' => array(
                'name'        => 'Euro',
                'code'        => '978',
                'country'     => 'SPAIN',
                'exponent'    => '2'
            ),
            'FJD' => array(
                'name'        => 'Fiji Dollar',
                'code'        => '242',
                'country'     => 'FIJI',
                'exponent'    => '2'
            ),
            'FKP' => array(
                'name'        => 'Falkland Islands Pound',
                'code'        => '238',
                'country'     => 'FALKLAND ISLANDS (THE) [MALVINAS]',
                'exponent'    => '2'
            ),
            'GBP' => array(
                'name'        => 'Pound Sterling',
                'code'        => '826',
                'country'     => 'UNITED KINGDOM OF GREAT BRITAIN AND NORTHERN IRELAND (THE)',
                'exponent'    => '2'
            ),
            'GEL' => array(
                'name'        => 'Lari',
                'code'        => '981',
                'country'     => 'GEORGIA',
                'exponent'    => '2'
            ),
            'GHS' => array(
                'name'        => 'Ghana Cedi',
                'code'        => '936',
                'country'     => 'GHANA',
                'exponent'    => '2'
            ),
            'GIP' => array(
                'name'        => 'Gibraltar Pound',
                'code'        => '292',
                'country'     => 'GIBRALTAR',
                'exponent'    => '2'
            ),
            'GMD' => array(
                'name'        => 'Dalasi',
                'code'        => '270',
                'country'     => 'GAMBIA (THE)',
                'exponent'    => '2'
            ),
            'GNF' => array(
                'name'        => 'Guinea Franc',
                'code'        => '324',
                'country'     => 'GUINEA',
                'exponent'    => '0'
            ),
            'GTQ' => array(
                'name'        => 'Quetzal',
                'code'        => '320',
                'country'     => 'GUATEMALA',
                'exponent'    => '2'
            ),
            'GYD' => array(
                'name'        => 'Guyana Dollar',
                'code'        => '328',
                'country'     => 'GUYANA',
                'exponent'    => '2'
            ),
            'HKD' => array(
                'name'        => 'Hong Kong Dollar',
                'code'        => '344',
                'country'     => 'HONG KONG',
                'exponent'    => '2'
            ),
            'HNL' => array(
                'name'        => 'Lempira',
                'code'        => '340',
                'country'     => 'HONDURAS',
                'exponent'    => '2'
            ),
            'HRK' => array(
                'name'        => 'Kuna',
                'code'        => '191',
                'country'     => 'CROATIA',
                'exponent'    => '2'
            ),
            'HTG' => array(
                'name'        => 'Gourde',
                'code'        => '332',
                'country'     => 'HAITI',
                'exponent'    => '2'
            ),
            'HUF' => array(
                'name'        => 'Forint',
                'code'        => '348',
                'country'     => 'HUNGARY',
                'exponent'    => '2'
            ),
            'IDR' => array(
                'name'        => 'Rupiah',
                'code'        => '360',
                'country'     => 'INDONESIA',
                'exponent'    => '2'
            ),
            'ILS' => array(
                'name'        => 'New Israeli Sheqel',
                'code'        => '376',
                'country'     => 'ISRAEL',
                'exponent'    => '2'
            ),
            'INR' => array(
                'name'        => 'Indian Rupee',
                'code'        => '356',
                'country'     => 'INDIA',
                'exponent'    => '2'
            ),
            'IQD' => array(
                'name'        => 'Iraqi Dinar',
                'code'        => '368',
                'country'     => 'IRAQ',
                'exponent'    => '3'
            ),
            'IRR' => array(
                'name'        => 'Iranian Rial',
                'code'        => '364',
                'country'     => 'IRAN (ISLAMIC REPUBLIC OF)',
                'exponent'    => '2'
            ),
            'ISK' => array(
                'name'        => 'Iceland Krona',
                'code'        => '352',
                'country'     => 'ICELAND',
                'exponent'    => '0'
            ),
            'JMD' => array(
                'name'        => 'Jamaican Dollar',
                'code'        => '388',
                'country'     => 'JAMAICA',
                'exponent'    => '2'
            ),
            'JOD' => array(
                'name'        => 'Jordanian Dinar',
                'code'        => '400',
                'country'     => 'JORDAN',
                'exponent'    => '3'
            ),
            'JPY' => array(
                'name'        => 'Yen',
                'code'        => '392',
                'country'     => 'JAPAN',
                'exponent'    => '0'
            ),
            'KES' => array(
                'name'        => 'Kenyan Shilling',
                'code'        => '404',
                'country'     => 'KENYA',
                'exponent'    => '2'
            ),
            'KGS' => array(
                'name'        => 'Som',
                'code'        => '417',
                'country'     => 'KYRGYZSTAN',
                'exponent'    => '2'
            ),
            'KHR' => array(
                'name'        => 'Riel',
                'code'        => '116',
                'country'     => 'CAMBODIA',
                'exponent'    => '2'
            ),
            'KMF' => array(
                'name'        => 'Comoro Franc',
                'code'        => '174',
                'country'     => 'COMOROS (THE)',
                'exponent'    => '0'
            ),
            'KPW' => array(
                'name'        => 'North Korean Won',
                'code'        => '408',
                'country'     => 'KOREA (THE DEMOCRATIC PEOPLEâ€™S REPUBLIC OF)',
                'exponent'    => '2'
            ),
            'KRW' => array(
                'name'        => 'Won',
                'code'        => '410',
                'country'     => 'KOREA (THE REPUBLIC OF)',
                'exponent'    => '0'
            ),
            'KWD' => array(
                'name'        => 'Kuwaiti Dinar',
                'code'        => '414',
                'country'     => 'KUWAIT',
                'exponent'    => '3'
            ),
            'KYD' => array(
                'name'        => 'Cayman Islands Dollar',
                'code'        => '136',
                'country'     => 'CAYMAN ISLANDS (THE)',
                'exponent'    => '2'
            ),
            'KZT' => array(
                'name'        => 'Tenge',
                'code'        => '398',
                'country'     => 'KAZAKHSTAN',
                'exponent'    => '2'
            ),
            'LAK' => array(
                'name'        => 'Kip',
                'code'        => '418',
                'country'     => 'LAO PEOPLEâ€™S DEMOCRATIC REPUBLIC (THE)',
                'exponent'    => '2'
            ),
            'LBP' => array(
                'name'        => 'Lebanese Pound',
                'code'        => '422',
                'country'     => 'LEBANON',
                'exponent'    => '2'
            ),
            'LKR' => array(
                'name'        => 'Sri Lanka Rupee',
                'code'        => '144',
                'country'     => 'SRI LANKA',
                'exponent'    => '2'
            ),
            'LRD' => array(
                'name'        => 'Liberian Dollar',
                'code'        => '430',
                'country'     => 'LIBERIA',
                'exponent'    => '2'
            ),
            'LSL' => array(
                'name'        => 'Loti',
                'code'        => '426',
                'country'     => 'LESOTHO',
                'exponent'    => '2'
            ),
            'LYD' => array(
                'name'        => 'Libyan Dinar',
                'code'        => '434',
                'country'     => 'LIBYA',
                'exponent'    => '3'
            ),
            'MAD' => array(
                'name'        => 'Moroccan Dirham',
                'code'        => '504',
                'country'     => 'WESTERN SAHARA',
                'exponent'    => '2'
            ),
            'MDL' => array(
                'name'        => 'Moldovan Leu',
                'code'        => '498',
                'country'     => 'MOLDOVA (THE REPUBLIC OF)',
                'exponent'    => '2'
            ),
            'MGA' => array(
                'name'        => 'Malagasy Ariary',
                'code'        => '969',
                'country'     => 'MADAGASCAR',
                'exponent'    => '2'
            ),
            'MKD' => array(
                'name'        => 'Denar',
                'code'        => '807',
                'country'     => 'MACEDONIA (THE FORMER YUGOSLAV REPUBLIC OF)',
                'exponent'    => '2'
            ),
            'MMK' => array(
                'name'        => 'Kyat',
                'code'        => '104',
                'country'     => 'MYANMAR',
                'exponent'    => '2'
            ),
            'MNT' => array(
                'name'        => 'Tugrik',
                'code'        => '496',
                'country'     => 'MONGOLIA',
                'exponent'    => '2'
            ),
            'MOP' => array(
                'name'        => 'Pataca',
                'code'        => '446',
                'country'     => 'MACAO',
                'exponent'    => '2'
            ),
            'MRO' => array(
                'name'        => 'Ouguiya',
                'code'        => '478',
                'country'     => 'MAURITANIA',
                'exponent'    => '2'
            ),
            'MUR' => array(
                'name'        => 'Mauritius Rupee',
                'code'        => '480',
                'country'     => 'MAURITIUS',
                'exponent'    => '2'
            ),
            'MVR' => array(
                'name'        => 'Rufiyaa',
                'code'        => '462',
                'country'     => 'MALDIVES',
                'exponent'    => '2'
            ),
            'MWK' => array(
                'name'        => 'Kwacha',
                'code'        => '454',
                'country'     => 'MALAWI',
                'exponent'    => '2'
            ),
            'MXN' => array(
                'name'        => 'Mexican Peso',
                'code'        => '484',
                'country'     => 'MEXICO',
                'exponent'    => '2'
            ),
            'MXV' => array(
                'name'        => 'Mexican Unidad de Inversion (UDI)',
                'code'        => '979',
                'country'     => 'MEXICO',
                'exponent'    => '2'
            ),
            'MYR' => array(
                'name'        => 'Malaysian Ringgit',
                'code'        => '458',
                'country'     => 'MALAYSIA',
                'exponent'    => '2'
            ),
            'MZN' => array(
                'name'        => 'Mozambique Metical',
                'code'        => '943',
                'country'     => 'MOZAMBIQUE',
                'exponent'    => '2'
            ),
            'NAD' => array(
                'name'        => 'Namibia Dollar',
                'code'        => '516',
                'country'     => 'NAMIBIA',
                'exponent'    => '2'
            ),
            'NGN' => array(
                'name'        => 'Naira',
                'code'        => '566',
                'country'     => 'NIGERIA',
                'exponent'    => '2'
            ),
            'NIO' => array(
                'name'        => 'Cordoba Oro',
                'code'        => '558',
                'country'     => 'NICARAGUA',
                'exponent'    => '2'
            ),
            'NOK' => array(
                'name'        => 'Norwegian Krone',
                'code'        => '578',
                'country'     => 'SVALBARD AND JAN MAYEN',
                'exponent'    => '2'
            ),
            'NPR' => array(
                'name'        => 'Nepalese Rupee',
                'code'        => '524',
                'country'     => 'NEPAL',
                'exponent'    => '2'
            ),
            'NZD' => array(
                'name'        => 'New Zealand Dollar',
                'code'        => '554',
                'country'     => 'TOKELAU',
                'exponent'    => '2'
            ),
            'OMR' => array(
                'name'        => 'Rial Omani',
                'code'        => '512',
                'country'     => 'OMAN',
                'exponent'    => '3'
            ),
            'PAB' => array(
                'name'        => 'Balboa',
                'code'        => '590',
                'country'     => 'PANAMA',
                'exponent'    => '2'
            ),
            'PEN' => array(
                'name'        => 'Nuevo Sol',
                'code'        => '604',
                'country'     => 'PERU',
                'exponent'    => '2'
            ),
            'PGK' => array(
                'name'        => 'Kina',
                'code'        => '598',
                'country'     => 'PAPUA NEW GUINEA',
                'exponent'    => '2'
            ),
            'PHP' => array(
                'name'        => 'Philippine Peso',
                'code'        => '608',
                'country'     => 'PHILIPPINES (THE)',
                'exponent'    => '2'
            ),
            'PKR' => array(
                'name'        => 'Pakistan Rupee',
                'code'        => '586',
                'country'     => 'PAKISTAN',
                'exponent'    => '2'
            ),
            'PLN' => array(
                'name'        => 'Zloty',
                'code'        => '985',
                'country'     => 'POLAND',
                'exponent'    => '2'
            ),
            'PYG' => array(
                'name'        => 'Guarani',
                'code'        => '600',
                'country'     => 'PARAGUAY',
                'exponent'    => '0'
            ),
            'QAR' => array(
                'name'        => 'Qatari Rial',
                'code'        => '634',
                'country'     => 'QATAR',
                'exponent'    => '2'
            ),
            'RON' => array(
                'name'        => 'Romanian Leu',
                'code'        => '946',
                'country'     => 'ROMANIA',
                'exponent'    => '2'
            ),
            'RSD' => array(
                'name'        => 'Serbian Dinar',
                'code'        => '941',
                'country'     => 'SERBIA',
                'exponent'    => '2'
            ),
            'RUB' => array(
                'name'        => 'Russian Ruble',
                'code'        => '643',
                'country'     => 'RUSSIAN FEDERATION (THE)',
                'exponent'    => '2'
            ),
            'RWF' => array(
                'name'        => 'Rwanda Franc',
                'code'        => '646',
                'country'     => 'RWANDA',
                'exponent'    => '0'
            ),
            'SAR' => array(
                'name'        => 'Saudi Riyal',
                'code'        => '682',
                'country'     => 'SAUDI ARABIA',
                'exponent'    => '2'
            ),
            'SBD' => array(
                'name'        => 'Solomon Islands Dollar',
                'code'        => '090',
                'country'     => 'SOLOMON ISLANDS',
                'exponent'    => '2'
            ),
            'SCR' => array(
                'name'        => 'Seychelles Rupee',
                'code'        => '690',
                'country'     => 'SEYCHELLES',
                'exponent'    => '2'
            ),
            'SDG' => array(
                'name'        => 'Sudanese Pound',
                'code'        => '938',
                'country'     => 'SUDAN (THE)',
                'exponent'    => '2'
            ),
            'SEK' => array(
                'name'        => 'Swedish Krona',
                'code'        => '752',
                'country'     => 'SWEDEN',
                'exponent'    => '2'
            ),
            'SGD' => array(
                'name'        => 'Singapore Dollar',
                'code'        => '702',
                'country'     => 'SINGAPORE',
                'exponent'    => '2'
            ),
            'SHP' => array(
                'name'        => 'Saint Helena Pound',
                'code'        => '654',
                'country'     => 'SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA',
                'exponent'    => '2'
            ),
            'SLL' => array(
                'name'        => 'Leone',
                'code'        => '694',
                'country'     => 'SIERRA LEONE',
                'exponent'    => '2'
            ),
            'SOS' => array(
                'name'        => 'Somali Shilling',
                'code'        => '706',
                'country'     => 'SOMALIA',
                'exponent'    => '2'
            ),
            'SRD' => array(
                'name'        => 'Surinam Dollar',
                'code'        => '968',
                'country'     => 'SURINAME',
                'exponent'    => '2'
            ),
            'SSP' => array(
                'name'        => 'South Sudanese Pound',
                'code'        => '728',
                'country'     => 'SOUTH SUDAN',
                'exponent'    => '2'
            ),
            'STD' => array(
                'name'        => 'Dobra',
                'code'        => '678',
                'country'     => 'SAO TOME AND PRINCIPE',
                'exponent'    => '2'
            ),
            'SVC' => array(
                'name'        => 'El Salvador Colon',
                'code'        => '222',
                'country'     => 'EL SALVADOR',
                'exponent'    => '2'
            ),
            'SYP' => array(
                'name'        => 'Syrian Pound',
                'code'        => '760',
                'country'     => 'SYRIAN ARAB REPUBLIC',
                'exponent'    => '2'
            ),
            'SZL' => array(
                'name'        => 'Lilangeni',
                'code'        => '748',
                'country'     => 'SWAZILAND',
                'exponent'    => '2'
            ),
            'THB' => array(
                'name'        => 'Baht',
                'code'        => '764',
                'country'     => 'THAILAND',
                'exponent'    => '2'
            ),
            'TJS' => array(
                'name'        => 'Somoni',
                'code'        => '972',
                'country'     => 'TAJIKISTAN',
                'exponent'    => '2'
            ),
            'TMT' => array(
                'name'        => 'Turkmenistan New Manat',
                'code'        => '934',
                'country'     => 'TURKMENISTAN',
                'exponent'    => '2'
            ),
            'TND' => array(
                'name'        => 'Tunisian Dinar',
                'code'        => '788',
                'country'     => 'TUNISIA',
                'exponent'    => '3'
            ),
            'TOP' => array(
                'name'        => 'Paâ€™anga',
                'code'        => '776',
                'country'     => 'TONGA',
                'exponent'    => '2'
            ),
            'TRY' => array(
                'name'        => 'Turkish Lira',
                'code'        => '949',
                'country'     => 'TURKEY',
                'exponent'    => '2'
            ),
            'TTD' => array(
                'name'        => 'Trinidad and Tobago Dollar',
                'code'        => '780',
                'country'     => 'TRINIDAD AND TOBAGO',
                'exponent'    => '2'
            ),
            'TWD' => array(
                'name'        => 'New Taiwan Dollar',
                'code'        => '901',
                'country'     => 'TAIWAN (PROVINCE OF CHINA)',
                'exponent'    => '2'
            ),
            'TZS' => array(
                'name'        => 'Tanzanian Shilling',
                'code'        => '834',
                'country'     => 'TANZANIA, UNITED REPUBLIC OF',
                'exponent'    => '2'
            ),
            'UAH' => array(
                'name'        => 'Hryvnia',
                'code'        => '980',
                'country'     => 'UKRAINE',
                'exponent'    => '2'
            ),
            'UGX' => array(
                'name'        => 'Uganda Shilling',
                'code'        => '800',
                'country'     => 'UGANDA',
                'exponent'    => '0'
            ),
            'USD' => array(
                'name'        => 'US Dollar',
                'code'        => '840',
                'country'     => 'VIRGIN ISLANDS (U.S.)',
                'exponent'    => '2'
            ),
            'USN' => array(
                'name'        => 'US Dollar (Next day)',
                'code'        => '997',
                'country'     => 'UNITED STATES OF AMERICA (THE)',
                'exponent'    => '2'
            ),
            'UYI' => array(
                'name'        => 'Uruguay Peso en Unidades Indexadas (URUIURUI)',
                'code'        => '940',
                'country'     => 'URUGUAY',
                'exponent'    => '0'
            ),
            'UYU' => array(
                'name'        => 'Peso Uruguayo',
                'code'        => '858',
                'country'     => 'URUGUAY',
                'exponent'    => '2'
            ),
            'UZS' => array(
                'name'        => 'Uzbekistan Sum',
                'code'        => '860',
                'country'     => 'UZBEKISTAN',
                'exponent'    => '2'
            ),
            'VEF' => array(
                'name'        => 'Bolivar',
                'code'        => '937',
                'country'     => 'VENEZUELA (BOLIVARIAN REPUBLIC OF)',
                'exponent'    => '2'
            ),
            'VND' => array(
                'name'        => 'Dong',
                'code'        => '704',
                'country'     => 'VIET NAM',
                'exponent'    => '0'
            ),
            'VUV' => array(
                'name'        => 'Vatu',
                'code'        => '548',
                'country'     => 'VANUATU',
                'exponent'    => '0'
            ),
            'WST' => array(
                'name'        => 'Tala',
                'code'        => '882',
                'country'     => 'SAMOA',
                'exponent'    => '2'
            ),
            'XAF' => array(
                'name'        => 'CFA Franc BEAC',
                'code'        => '950',
                'country'     => 'GABON',
                'exponent'    => '0'
            ),
            'XAG' => array(
                'name'        => 'Silver',
                'code'        => '961',
                'country'     => 'ZZ11_Silver',
                'exponent'    => 'N.A.'
            ),
            'XAU' => array(
                'name'        => 'Gold',
                'code'        => '959',
                'country'     => 'ZZ08_Gold',
                'exponent'    => 'N.A.'
            ),
            'XBA' => array(
                'name'        => 'Bond Markets Unit European Composite Unit (EURCO)',
                'code'        => '955',
                'country'     => 'ZZ01_Bond Markets Unit European_EURCO',
                'exponent'    => 'N.A.'
            ),
            'XBB' => array(
                'name'        => 'Bond Markets Unit European Monetary Unit (E.M.U.-6)',
                'code'        => '956',
                'country'     => 'ZZ02_Bond Markets Unit European_EMU-6',
                'exponent'    => 'N.A.'
            ),
            'XBC' => array(
                'name'        => 'Bond Markets Unit European Unit of Account 9 (E.U.A.-9)',
                'code'        => '957',
                'country'     => 'ZZ03_Bond Markets Unit European_EUA-9',
                'exponent'    => 'N.A.'
            ),
            'XBD' => array(
                'name'        => 'Bond Markets Unit European Unit of Account 17 (E.U.A.-17)',
                'code'        => '958',
                'country'     => 'ZZ04_Bond Markets Unit European_EUA-17',
                'exponent'    => 'N.A.'
            ),
            'XCD' => array(
                'name'        => 'East Caribbean Dollar',
                'code'        => '951',
                'country'     => 'SAINT VINCENT AND THE GRENADINES',
                'exponent'    => '2'
            ),
            'XDR' => array(
                'name'        => 'SDR (Special Drawing Right)',
                'code'        => '960',
                'country'     => 'INTERNATIONAL MONETARY FUND (IMF)Â ',
                'exponent'    => 'N.A.'
            ),
            'XOF' => array(
                'name'        => 'CFA Franc BCEAO',
                'code'        => '952',
                'country'     => 'TOGO',
                'exponent'    => '0'
            ),
            'XPD' => array(
                'name'        => 'Palladium',
                'code'        => '964',
                'country'     => 'ZZ09_Palladium',
                'exponent'    => 'N.A.'
            ),
            'XPF' => array(
                'name'        => 'CFP Franc',
                'code'        => '953',
                'country'     => 'WALLIS AND FUTUNA',
                'exponent'    => '0'
            ),
            'XPT' => array(
                'name'        => 'Platinum',
                'code'        => '962',
                'country'     => 'ZZ10_Platinum',
                'exponent'    => 'N.A.'
            ),
            'XSU' => array(
                'name'        => 'Sucre',
                'code'        => '994',
                'country'     => 'SISTEMA UNITARIO DE COMPENSACION REGIONAL DE PAGOS "SUCRE"',
                'exponent'    => 'N.A.'
            ),
            'XTS' => array(
                'name'        => 'Codes specifically reserved for testing purposes',
                'code'        => '963',
                'country'     => 'ZZ06_Testing_Code',
                'exponent'    => 'N.A.'
            ),
            'XUA' => array(
                'name'        => 'ADB Unit of Account',
                'code'        => '965',
                'country'     => 'MEMBER COUNTRIES OF THE AFRICAN DEVELOPMENT BANK GROUP',
                'exponent'    => 'N.A.'
            ),
            'XXX' => array(
                'name'        => 'The codes assigned for transactions where no currency is involved',
                'code'        => '999',
                'country'     => 'ZZ07_No_Currency',
                'exponent'    => 'N.A.'
            ),
            'YER' => array(
                'name'        => 'Yemeni Rial',
                'code'        => '886',
                'country'     => 'YEMEN',
                'exponent'    => '2'
            ),
            'ZAR' => array(
                'name'        => 'Rand',
                'code'        => '710',
                'country'     => 'SOUTH AFRICA',
                'exponent'    => '2'
            ),
            'ZMW' => array(
                'name'        => 'Zambian Kwacha',
                'code'        => '967',
                'country'     => 'ZAMBIA',
                'exponent'    => '2'
            ),
            'ZWL' => array(
                'name'        => 'Zimbabwe Dollar',
                'code'        => '932',
                'country'     => 'ZIMBABWE',
                'exponent'    => '2'
            ),
        );

    /**
     * Convert amount to ISO-4217 minor currency unit
     *
     * @param $amount - amount to convert
     * @param $iso    - iso code of the currency
     *
     * @return mixed  - using string as we don't want to cast it without knowing how much precision
     *                is required
     */
    public static function amountToExponent($amount, $iso)
    {
        $iso = strtoupper($iso);

        if (array_key_exists($iso, self::$iso4217)) {
            $exp = intval(self::$iso4217[$iso]['exponent']);

            if ($exp > 0) {
                return bcmul($amount, pow(10, $exp), 0);
            }
        }

        return strval($amount);
    }

    /**
     * Convert ISO-4217 minor currency unit to amount
     *
     * @param $amount - amount to convert
     * @param $iso    - iso code of the currency
     *
     * @return string - using string as we don't want to cast it without knowing how much precision
     *                is required
     */
    public static function exponentToAmount($amount, $iso)
    {
        $iso = strtoupper($iso);

        if (array_key_exists($iso, self::$iso4217)) {
            $exp = intval(self::$iso4217[$iso]['exponent']);

            if ($exp > 0) {
                return bcdiv($amount, pow(10, $exp), $exp);
            }
        }

        return strval($amount);
    }
}

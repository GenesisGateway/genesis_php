<?php

/**
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"], to deal
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

use Genesis\Exceptions\InvalidArgument;

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
        = [
            'AED' => [
                'name'        => 'UAE Dirham',
                'code'        => '784',
                'country'     => 'UNITED ARAB EMIRATES (THE)',
                'exponent'    => '2'
            ],
            'AFN' => [
                'name'        => 'Afghani',
                'code'        => '971',
                'country'     => 'AFGHANISTAN',
                'exponent'    => '2'
            ],
            'ALL' => [
                'name'        => 'Lek',
                'code'        => '008',
                'country'     => 'ALBANIA',
                'exponent'    => '2'
            ],
            'AMD' => [
                'name'        => 'Armenian Dram',
                'code'        => '051',
                'country'     => 'ARMENIA',
                'exponent'    => '2'
            ],
            'ANG' => [
                'name'        => 'Netherlands Antillean Guilder',
                'code'        => '532',
                'country'     => 'SINT MAARTEN (DUTCH PART)',
                'exponent'    => '2'
            ],
            'AOA' => [
                'name'        => 'Kwanza',
                'code'        => '973',
                'country'     => 'ANGOLA',
                'exponent'    => '2'
            ],
            'ARS' => [
                'name'        => 'Argentine Peso',
                'code'        => '032',
                'country'     => 'ARGENTINA',
                'exponent'    => '2'
            ],
            'AUD' => [
                'name'        => 'Australian Dollar',
                'code'        => '036',
                'country'     => 'TUVALU',
                'exponent'    => '2'
            ],
            'AWG' => [
                'name'        => 'Aruban Florin',
                'code'        => '533',
                'country'     => 'ARUBA',
                'exponent'    => '2'
            ],
            'AZN' => [
                'name'        => 'Azerbaijanian Manat',
                'code'        => '944',
                'country'     => 'AZERBAIJAN',
                'exponent'    => '2'
            ],
            'BAM' => [
                'name'        => 'Convertible Mark',
                'code'        => '977',
                'country'     => 'BOSNIA AND HERZEGOVINA',
                'exponent'    => '2'
            ],
            'BBD' => [
                'name'        => 'Barbados Dollar',
                'code'        => '052',
                'country'     => 'BARBADOS',
                'exponent'    => '2'
            ],
            'BDT' => [
                'name'        => 'Taka',
                'code'        => '050',
                'country'     => 'BANGLADESH',
                'exponent'    => '2'
            ],
            'BGN' => [
                'name'        => 'Bulgarian Lev',
                'code'        => '975',
                'country'     => 'BULGARIA',
                'exponent'    => '2'
            ],
            'BHD' => [
                'name'        => 'Bahraini Dinar',
                'code'        => '048',
                'country'     => 'BAHRAIN',
                'exponent'    => '3'
            ],
            'BIF' => [
                'name'        => 'Burundi Franc',
                'code'        => '108',
                'country'     => 'BURUNDI',
                'exponent'    => '0'
            ],
            'BMD' => [
                'name'        => 'Bermudian Dollar',
                'code'        => '060',
                'country'     => 'BERMUDA',
                'exponent'    => '2'
            ],
            'BND' => [
                'name'        => 'Brunei Dollar',
                'code'        => '096',
                'country'     => 'BRUNEI DARUSSALAM',
                'exponent'    => '2'
            ],
            'BOB' => [
                'name'        => 'Boliviano',
                'code'        => '068',
                'country'     => 'BOLIVIA (PLURINATIONAL STATE OF)',
                'exponent'    => '2'
            ],
            'BOV' => [
                'name'        => 'Mvdol',
                'code'        => '984',
                'country'     => 'BOLIVIA (PLURINATIONAL STATE OF)',
                'exponent'    => '2'
            ],
            'BRL' => [
                'name'        => 'Brazilian Real',
                'code'        => '986',
                'country'     => 'BRAZIL',
                'exponent'    => '2'
            ],
            'BSD' => [
                'name'        => 'Bahamian Dollar',
                'code'        => '044',
                'country'     => 'BAHAMAS (THE)',
                'exponent'    => '2'
            ],
            'BTN' => [
                'name'        => 'Ngultrum',
                'code'        => '064',
                'country'     => 'BHUTAN',
                'exponent'    => '2'
            ],
            'BWP' => [
                'name'        => 'Pula',
                'code'        => '072',
                'country'     => 'BOTSWANA',
                'exponent'    => '2'
            ],
            'BYR' => [
                'name'        => 'Belarussian Ruble',
                'code'        => '974',
                'country'     => 'BELARUS',
                'exponent'    => '0'
            ],
            'BZD' => [
                'name'        => 'Belize Dollar',
                'code'        => '084',
                'country'     => 'BELIZE',
                'exponent'    => '2'
            ],
            'CAD' => [
                'name'        => 'Canadian Dollar',
                'code'        => '124',
                'country'     => 'CANADA',
                'exponent'    => '2'
            ],
            'CDF' => [
                'name'        => 'Congolese Franc',
                'code'        => '976',
                'country'     => 'CONGO (THE DEMOCRATIC REPUBLIC OF THE)',
                'exponent'    => '2'
            ],
            'CHE' => [
                'name'        => 'WIR Euro',
                'code'        => '947',
                'country'     => 'SWITZERLAND',
                'exponent'    => '2'
            ],
            'CHF' => [
                'name'        => 'Swiss Franc',
                'code'        => '756',
                'country'     => 'SWITZERLAND',
                'exponent'    => '2'
            ],
            'CHW' => [
                'name'        => 'WIR Franc',
                'code'        => '948',
                'country'     => 'SWITZERLAND',
                'exponent'    => '2'
            ],
            'CLF' => [
                'name'        => 'Unidad de Fomento',
                'code'        => '990',
                'country'     => 'CHILE',
                'exponent'    => '4'
            ],
            'CLP' => [
                'name'        => 'Chilean Peso',
                'code'        => '152',
                'country'     => 'CHILE',
                'exponent'    => '0'
            ],
            'CNY' => [
                'name'        => 'Yuan Renminbi',
                'code'        => '156',
                'country'     => 'CHINA',
                'exponent'    => '2'
            ],
            'COP' => [
                'name'        => 'Colombian Peso',
                'code'        => '170',
                'country'     => 'COLOMBIA',
                'exponent'    => '2'
            ],
            'COU' => [
                'name'        => 'Unidad de Valor Real',
                'code'        => '970',
                'country'     => 'COLOMBIA',
                'exponent'    => '2'
            ],
            'CRC' => [
                'name'        => 'Costa Rican Colon',
                'code'        => '188',
                'country'     => 'COSTA RICA',
                'exponent'    => '2'
            ],
            'CUC' => [
                'name'        => 'Peso Convertible',
                'code'        => '931',
                'country'     => 'CUBA',
                'exponent'    => '2'
            ],
            'CUP' => [
                'name'        => 'Cuban Peso',
                'code'        => '192',
                'country'     => 'CUBA',
                'exponent'    => '2'
            ],
            'CVE' => [
                'name'        => 'Cabo Verde Escudo',
                'code'        => '132',
                'country'     => 'CABO VERDE',
                'exponent'    => '2'
            ],
            'CZK' => [
                'name'        => 'Czech Koruna',
                'code'        => '203',
                'country'     => 'CZECH REPUBLIC (THE)',
                'exponent'    => '2'
            ],
            'DJF' => [
                'name'        => 'Djibouti Franc',
                'code'        => '262',
                'country'     => 'DJIBOUTI',
                'exponent'    => '0'
            ],
            'DKK' => [
                'name'        => 'Danish Krone',
                'code'        => '208',
                'country'     => 'GREENLAND',
                'exponent'    => '2'
            ],
            'DOP' => [
                'name'        => 'Dominican Peso',
                'code'        => '214',
                'country'     => 'DOMINICAN REPUBLIC (THE)',
                'exponent'    => '2'
            ],
            'DZD' => [
                'name'        => 'Algerian Dinar',
                'code'        => '012',
                'country'     => 'ALGERIA',
                'exponent'    => '2'
            ],
            'EGP' => [
                'name'        => 'Egyptian Pound',
                'code'        => '818',
                'country'     => 'EGYPT',
                'exponent'    => '2'
            ],
            'ERN' => [
                'name'        => 'Nakfa',
                'code'        => '232',
                'country'     => 'ERITREA',
                'exponent'    => '2'
            ],
            'ETB' => [
                'name'        => 'Ethiopian Birr',
                'code'        => '230',
                'country'     => 'ETHIOPIA',
                'exponent'    => '2'
            ],
            'EUR' => [
                'name'        => 'Euro',
                'code'        => '978',
                'country'     => 'SPAIN',
                'exponent'    => '2'
            ],
            'FJD' => [
                'name'        => 'Fiji Dollar',
                'code'        => '242',
                'country'     => 'FIJI',
                'exponent'    => '2'
            ],
            'FKP' => [
                'name'        => 'Falkland Islands Pound',
                'code'        => '238',
                'country'     => 'FALKLAND ISLANDS (THE) [MALVINAS]',
                'exponent'    => '2'
            ],
            'GBP' => [
                'name'        => 'Pound Sterling',
                'code'        => '826',
                'country'     => 'UNITED KINGDOM OF GREAT BRITAIN AND NORTHERN IRELAND (THE)',
                'exponent'    => '2'
            ],
            'GEL' => [
                'name'        => 'Lari',
                'code'        => '981',
                'country'     => 'GEORGIA',
                'exponent'    => '2'
            ],
            'GHS' => [
                'name'        => 'Ghana Cedi',
                'code'        => '936',
                'country'     => 'GHANA',
                'exponent'    => '2'
            ],
            'GIP' => [
                'name'        => 'Gibraltar Pound',
                'code'        => '292',
                'country'     => 'GIBRALTAR',
                'exponent'    => '2'
            ],
            'GMD' => [
                'name'        => 'Dalasi',
                'code'        => '270',
                'country'     => 'GAMBIA (THE)',
                'exponent'    => '2'
            ],
            'GNF' => [
                'name'        => 'Guinea Franc',
                'code'        => '324',
                'country'     => 'GUINEA',
                'exponent'    => '0'
            ],
            'GTQ' => [
                'name'        => 'Quetzal',
                'code'        => '320',
                'country'     => 'GUATEMALA',
                'exponent'    => '2'
            ],
            'GYD' => [
                'name'        => 'Guyana Dollar',
                'code'        => '328',
                'country'     => 'GUYANA',
                'exponent'    => '2'
            ],
            'HKD' => [
                'name'        => 'Hong Kong Dollar',
                'code'        => '344',
                'country'     => 'HONG KONG',
                'exponent'    => '2'
            ],
            'HNL' => [
                'name'        => 'Lempira',
                'code'        => '340',
                'country'     => 'HONDURAS',
                'exponent'    => '2'
            ],
            'HRK' => [
                'name'        => 'Kuna',
                'code'        => '191',
                'country'     => 'CROATIA',
                'exponent'    => '2'
            ],
            'HTG' => [
                'name'        => 'Gourde',
                'code'        => '332',
                'country'     => 'HAITI',
                'exponent'    => '2'
            ],
            'HUF' => [
                'name'        => 'Forint',
                'code'        => '348',
                'country'     => 'HUNGARY',
                'exponent'    => '2'
            ],
            'IDR' => [
                'name'        => 'Rupiah',
                'code'        => '360',
                'country'     => 'INDONESIA',
                'exponent'    => '2'
            ],
            'ILS' => [
                'name'        => 'New Israeli Sheqel',
                'code'        => '376',
                'country'     => 'ISRAEL',
                'exponent'    => '2'
            ],
            'INR' => [
                'name'        => 'Indian Rupee',
                'code'        => '356',
                'country'     => 'INDIA',
                'exponent'    => '2'
            ],
            'IQD' => [
                'name'        => 'Iraqi Dinar',
                'code'        => '368',
                'country'     => 'IRAQ',
                'exponent'    => '3'
            ],
            'IRR' => [
                'name'        => 'Iranian Rial',
                'code'        => '364',
                'country'     => 'IRAN (ISLAMIC REPUBLIC OF)',
                'exponent'    => '2'
            ],
            'ISK' => [
                'name'        => 'Iceland Krona',
                'code'        => '352',
                'country'     => 'ICELAND',
                'exponent'    => '0'
            ],
            'JMD' => [
                'name'        => 'Jamaican Dollar',
                'code'        => '388',
                'country'     => 'JAMAICA',
                'exponent'    => '2'
            ],
            'JOD' => [
                'name'        => 'Jordanian Dinar',
                'code'        => '400',
                'country'     => 'JORDAN',
                'exponent'    => '3'
            ],
            'JPY' => [
                'name'        => 'Yen',
                'code'        => '392',
                'country'     => 'JAPAN',
                'exponent'    => '0'
            ],
            'KES' => [
                'name'        => 'Kenyan Shilling',
                'code'        => '404',
                'country'     => 'KENYA',
                'exponent'    => '2'
            ],
            'KGS' => [
                'name'        => 'Som',
                'code'        => '417',
                'country'     => 'KYRGYZSTAN',
                'exponent'    => '2'
            ],
            'KHR' => [
                'name'        => 'Riel',
                'code'        => '116',
                'country'     => 'CAMBODIA',
                'exponent'    => '2'
            ],
            'KMF' => [
                'name'        => 'Comoro Franc',
                'code'        => '174',
                'country'     => 'COMOROS (THE)',
                'exponent'    => '0'
            ],
            'KPW' => [
                'name'        => 'North Korean Won',
                'code'        => '408',
                'country'     => 'KOREA (THE DEMOCRATIC PEOPLEâ€™S REPUBLIC OF)',
                'exponent'    => '2'
            ],
            'KRW' => [
                'name'        => 'Won',
                'code'        => '410',
                'country'     => 'KOREA (THE REPUBLIC OF)',
                'exponent'    => '0'
            ],
            'KWD' => [
                'name'        => 'Kuwaiti Dinar',
                'code'        => '414',
                'country'     => 'KUWAIT',
                'exponent'    => '3'
            ],
            'KYD' => [
                'name'        => 'Cayman Islands Dollar',
                'code'        => '136',
                'country'     => 'CAYMAN ISLANDS (THE)',
                'exponent'    => '2'
            ],
            'KZT' => [
                'name'        => 'Tenge',
                'code'        => '398',
                'country'     => 'KAZAKHSTAN',
                'exponent'    => '2'
            ],
            'LAK' => [
                'name'        => 'Kip',
                'code'        => '418',
                'country'     => 'LAO PEOPLEâ€™S DEMOCRATIC REPUBLIC (THE)',
                'exponent'    => '2'
            ],
            'LBP' => [
                'name'        => 'Lebanese Pound',
                'code'        => '422',
                'country'     => 'LEBANON',
                'exponent'    => '2'
            ],
            'LKR' => [
                'name'        => 'Sri Lanka Rupee',
                'code'        => '144',
                'country'     => 'SRI LANKA',
                'exponent'    => '2'
            ],
            'LRD' => [
                'name'        => 'Liberian Dollar',
                'code'        => '430',
                'country'     => 'LIBERIA',
                'exponent'    => '2'
            ],
            'LSL' => [
                'name'        => 'Loti',
                'code'        => '426',
                'country'     => 'LESOTHO',
                'exponent'    => '2'
            ],
            'LYD' => [
                'name'        => 'Libyan Dinar',
                'code'        => '434',
                'country'     => 'LIBYA',
                'exponent'    => '3'
            ],
            'MAD' => [
                'name'        => 'Moroccan Dirham',
                'code'        => '504',
                'country'     => 'WESTERN SAHARA',
                'exponent'    => '2'
            ],
            'MDL' => [
                'name'        => 'Moldovan Leu',
                'code'        => '498',
                'country'     => 'MOLDOVA (THE REPUBLIC OF)',
                'exponent'    => '2'
            ],
            'MGA' => [
                'name'        => 'Malagasy Ariary',
                'code'        => '969',
                'country'     => 'MADAGASCAR',
                'exponent'    => '2'
            ],
            'MKD' => [
                'name'        => 'Denar',
                'code'        => '807',
                'country'     => 'MACEDONIA (THE FORMER YUGOSLAV REPUBLIC OF)',
                'exponent'    => '2'
            ],
            'MMK' => [
                'name'        => 'Kyat',
                'code'        => '104',
                'country'     => 'MYANMAR',
                'exponent'    => '2'
            ],
            'MNT' => [
                'name'        => 'Tugrik',
                'code'        => '496',
                'country'     => 'MONGOLIA',
                'exponent'    => '2'
            ],
            'MOP' => [
                'name'        => 'Pataca',
                'code'        => '446',
                'country'     => 'MACAO',
                'exponent'    => '2'
            ],
            'MRO' => [
                'name'        => 'Ouguiya',
                'code'        => '478',
                'country'     => 'MAURITANIA',
                'exponent'    => '2'
            ],
            'MUR' => [
                'name'        => 'Mauritius Rupee',
                'code'        => '480',
                'country'     => 'MAURITIUS',
                'exponent'    => '2'
            ],
            'MVR' => [
                'name'        => 'Rufiyaa',
                'code'        => '462',
                'country'     => 'MALDIVES',
                'exponent'    => '2'
            ],
            'MWK' => [
                'name'        => 'Kwacha',
                'code'        => '454',
                'country'     => 'MALAWI',
                'exponent'    => '2'
            ],
            'MXN' => [
                'name'        => 'Mexican Peso',
                'code'        => '484',
                'country'     => 'MEXICO',
                'exponent'    => '2'
            ],
            'MXV' => [
                'name'        => 'Mexican Unidad de Inversion (UDI)',
                'code'        => '979',
                'country'     => 'MEXICO',
                'exponent'    => '2'
            ],
            'MYR' => [
                'name'        => 'Malaysian Ringgit',
                'code'        => '458',
                'country'     => 'MALAYSIA',
                'exponent'    => '2'
            ],
            'MZN' => [
                'name'        => 'Mozambique Metical',
                'code'        => '943',
                'country'     => 'MOZAMBIQUE',
                'exponent'    => '2'
            ],
            'NAD' => [
                'name'        => 'Namibia Dollar',
                'code'        => '516',
                'country'     => 'NAMIBIA',
                'exponent'    => '2'
            ],
            'NGN' => [
                'name'        => 'Naira',
                'code'        => '566',
                'country'     => 'NIGERIA',
                'exponent'    => '2'
            ],
            'NIO' => [
                'name'        => 'Cordoba Oro',
                'code'        => '558',
                'country'     => 'NICARAGUA',
                'exponent'    => '2'
            ],
            'NOK' => [
                'name'        => 'Norwegian Krone',
                'code'        => '578',
                'country'     => 'SVALBARD AND JAN MAYEN',
                'exponent'    => '2'
            ],
            'NPR' => [
                'name'        => 'Nepalese Rupee',
                'code'        => '524',
                'country'     => 'NEPAL',
                'exponent'    => '2'
            ],
            'NZD' => [
                'name'        => 'New Zealand Dollar',
                'code'        => '554',
                'country'     => 'TOKELAU',
                'exponent'    => '2'
            ],
            'OMR' => [
                'name'        => 'Rial Omani',
                'code'        => '512',
                'country'     => 'OMAN',
                'exponent'    => '3'
            ],
            'PAB' => [
                'name'        => 'Balboa',
                'code'        => '590',
                'country'     => 'PANAMA',
                'exponent'    => '2'
            ],
            'PEN' => [
                'name'        => 'Nuevo Sol',
                'code'        => '604',
                'country'     => 'PERU',
                'exponent'    => '2'
            ],
            'PGK' => [
                'name'        => 'Kina',
                'code'        => '598',
                'country'     => 'PAPUA NEW GUINEA',
                'exponent'    => '2'
            ],
            'PHP' => [
                'name'        => 'Philippine Peso',
                'code'        => '608',
                'country'     => 'PHILIPPINES (THE)',
                'exponent'    => '2'
            ],
            'PKR' => [
                'name'        => 'Pakistan Rupee',
                'code'        => '586',
                'country'     => 'PAKISTAN',
                'exponent'    => '2'
            ],
            'PLN' => [
                'name'        => 'Zloty',
                'code'        => '985',
                'country'     => 'POLAND',
                'exponent'    => '2'
            ],
            'PYG' => [
                'name'        => 'Guarani',
                'code'        => '600',
                'country'     => 'PARAGUAY',
                'exponent'    => '0'
            ],
            'QAR' => [
                'name'        => 'Qatari Rial',
                'code'        => '634',
                'country'     => 'QATAR',
                'exponent'    => '2'
            ],
            'RON' => [
                'name'        => 'Romanian Leu',
                'code'        => '946',
                'country'     => 'ROMANIA',
                'exponent'    => '2'
            ],
            'RSD' => [
                'name'        => 'Serbian Dinar',
                'code'        => '941',
                'country'     => 'SERBIA',
                'exponent'    => '2'
            ],
            'RUB' => [
                'name'        => 'Russian Ruble',
                'code'        => '643',
                'country'     => 'RUSSIAN FEDERATION (THE)',
                'exponent'    => '2'
            ],
            'RWF' => [
                'name'        => 'Rwanda Franc',
                'code'        => '646',
                'country'     => 'RWANDA',
                'exponent'    => '0'
            ],
            'SAR' => [
                'name'        => 'Saudi Riyal',
                'code'        => '682',
                'country'     => 'SAUDI ARABIA',
                'exponent'    => '2'
            ],
            'SBD' => [
                'name'        => 'Solomon Islands Dollar',
                'code'        => '090',
                'country'     => 'SOLOMON ISLANDS',
                'exponent'    => '2'
            ],
            'SCR' => [
                'name'        => 'Seychelles Rupee',
                'code'        => '690',
                'country'     => 'SEYCHELLES',
                'exponent'    => '2'
            ],
            'SDG' => [
                'name'        => 'Sudanese Pound',
                'code'        => '938',
                'country'     => 'SUDAN (THE)',
                'exponent'    => '2'
            ],
            'SEK' => [
                'name'        => 'Swedish Krona',
                'code'        => '752',
                'country'     => 'SWEDEN',
                'exponent'    => '2'
            ],
            'SGD' => [
                'name'        => 'Singapore Dollar',
                'code'        => '702',
                'country'     => 'SINGAPORE',
                'exponent'    => '2'
            ],
            'SHP' => [
                'name'        => 'Saint Helena Pound',
                'code'        => '654',
                'country'     => 'SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA',
                'exponent'    => '2'
            ],
            'SLL' => [
                'name'        => 'Leone',
                'code'        => '694',
                'country'     => 'SIERRA LEONE',
                'exponent'    => '2'
            ],
            'SOS' => [
                'name'        => 'Somali Shilling',
                'code'        => '706',
                'country'     => 'SOMALIA',
                'exponent'    => '2'
            ],
            'SRD' => [
                'name'        => 'Surinam Dollar',
                'code'        => '968',
                'country'     => 'SURINAME',
                'exponent'    => '2'
            ],
            'SSP' => [
                'name'        => 'South Sudanese Pound',
                'code'        => '728',
                'country'     => 'SOUTH SUDAN',
                'exponent'    => '2'
            ],
            'STD' => [
                'name'        => 'Dobra',
                'code'        => '678',
                'country'     => 'SAO TOME AND PRINCIPE',
                'exponent'    => '2'
            ],
            'SVC' => [
                'name'        => 'El Salvador Colon',
                'code'        => '222',
                'country'     => 'EL SALVADOR',
                'exponent'    => '2'
            ],
            'SYP' => [
                'name'        => 'Syrian Pound',
                'code'        => '760',
                'country'     => 'SYRIAN ARAB REPUBLIC',
                'exponent'    => '2'
            ],
            'SZL' => [
                'name'        => 'Lilangeni',
                'code'        => '748',
                'country'     => 'SWAZILAND',
                'exponent'    => '2'
            ],
            'THB' => [
                'name'        => 'Baht',
                'code'        => '764',
                'country'     => 'THAILAND',
                'exponent'    => '2'
            ],
            'TJS' => [
                'name'        => 'Somoni',
                'code'        => '972',
                'country'     => 'TAJIKISTAN',
                'exponent'    => '2'
            ],
            'TMT' => [
                'name'        => 'Turkmenistan New Manat',
                'code'        => '934',
                'country'     => 'TURKMENISTAN',
                'exponent'    => '2'
            ],
            'TND' => [
                'name'        => 'Tunisian Dinar',
                'code'        => '788',
                'country'     => 'TUNISIA',
                'exponent'    => '3'
            ],
            'TOP' => [
                'name'        => 'Paâ€™anga',
                'code'        => '776',
                'country'     => 'TONGA',
                'exponent'    => '2'
            ],
            'TRY' => [
                'name'        => 'Turkish Lira',
                'code'        => '949',
                'country'     => 'TURKEY',
                'exponent'    => '2'
            ],
            'TTD' => [
                'name'        => 'Trinidad and Tobago Dollar',
                'code'        => '780',
                'country'     => 'TRINIDAD AND TOBAGO',
                'exponent'    => '2'
            ],
            'TWD' => [
                'name'        => 'New Taiwan Dollar',
                'code'        => '901',
                'country'     => 'TAIWAN (PROVINCE OF CHINA)',
                'exponent'    => '2'
            ],
            'TZS' => [
                'name'        => 'Tanzanian Shilling',
                'code'        => '834',
                'country'     => 'TANZANIA, UNITED REPUBLIC OF',
                'exponent'    => '2'
            ],
            'UAH' => [
                'name'        => 'Hryvnia',
                'code'        => '980',
                'country'     => 'UKRAINE',
                'exponent'    => '2'
            ],
            'UGX' => [
                'name'        => 'Uganda Shilling',
                'code'        => '800',
                'country'     => 'UGANDA',
                'exponent'    => '0'
            ],
            'USD' => [
                'name'        => 'US Dollar',
                'code'        => '840',
                'country'     => 'VIRGIN ISLANDS (U.S.)',
                'exponent'    => '2'
            ],
            'USN' => [
                'name'        => 'US Dollar (Next day)',
                'code'        => '997',
                'country'     => 'UNITED STATES OF AMERICA (THE)',
                'exponent'    => '2'
            ],
            'UYI' => [
                'name'        => 'Uruguay Peso en Unidades Indexadas (URUIURUI)',
                'code'        => '940',
                'country'     => 'URUGUAY',
                'exponent'    => '0'
            ],
            'UYU' => [
                'name'        => 'Peso Uruguayo',
                'code'        => '858',
                'country'     => 'URUGUAY',
                'exponent'    => '2'
            ],
            'UZS' => [
                'name'        => 'Uzbekistan Sum',
                'code'        => '860',
                'country'     => 'UZBEKISTAN',
                'exponent'    => '2'
            ],
            'VEF' => [
                'name'        => 'Bolivar',
                'code'        => '937',
                'country'     => 'VENEZUELA (BOLIVARIAN REPUBLIC OF)',
                'exponent'    => '2'
            ],
            'VND' => [
                'name'        => 'Dong',
                'code'        => '704',
                'country'     => 'VIET NAM',
                'exponent'    => '0'
            ],
            'VUV' => [
                'name'        => 'Vatu',
                'code'        => '548',
                'country'     => 'VANUATU',
                'exponent'    => '0'
            ],
            'WST' => [
                'name'        => 'Tala',
                'code'        => '882',
                'country'     => 'SAMOA',
                'exponent'    => '2'
            ],
            'XAF' => [
                'name'        => 'CFA Franc BEAC',
                'code'        => '950',
                'country'     => 'GABON',
                'exponent'    => '0'
            ],
            'XAG' => [
                'name'        => 'Silver',
                'code'        => '961',
                'country'     => 'ZZ11_Silver',
                'exponent'    => 'N.A.'
            ],
            'XAU' => [
                'name'        => 'Gold',
                'code'        => '959',
                'country'     => 'ZZ08_Gold',
                'exponent'    => 'N.A.'
            ],
            'XBA' => [
                'name'        => 'Bond Markets Unit European Composite Unit (EURCO)',
                'code'        => '955',
                'country'     => 'ZZ01_Bond Markets Unit European_EURCO',
                'exponent'    => 'N.A.'
            ],
            'XBB' => [
                'name'        => 'Bond Markets Unit European Monetary Unit (E.M.U.-6)',
                'code'        => '956',
                'country'     => 'ZZ02_Bond Markets Unit European_EMU-6',
                'exponent'    => 'N.A.'
            ],
            'XBC' => [
                'name'        => 'Bond Markets Unit European Unit of Account 9 (E.U.A.-9)',
                'code'        => '957',
                'country'     => 'ZZ03_Bond Markets Unit European_EUA-9',
                'exponent'    => 'N.A.'
            ],
            'XBD' => [
                'name'        => 'Bond Markets Unit European Unit of Account 17 (E.U.A.-17)',
                'code'        => '958',
                'country'     => 'ZZ04_Bond Markets Unit European_EUA-17',
                'exponent'    => 'N.A.'
            ],
            'XCD' => [
                'name'        => 'East Caribbean Dollar',
                'code'        => '951',
                'country'     => 'SAINT VINCENT AND THE GRENADINES',
                'exponent'    => '2'
            ],
            'XDR' => [
                'name'        => 'SDR (Special Drawing Right)',
                'code'        => '960',
                'country'     => 'INTERNATIONAL MONETARY FUND (IMF)Â ',
                'exponent'    => 'N.A.'
            ],
            'XOF' => [
                'name'        => 'CFA Franc BCEAO',
                'code'        => '952',
                'country'     => 'TOGO',
                'exponent'    => '0'
            ],
            'XPD' => [
                'name'        => 'Palladium',
                'code'        => '964',
                'country'     => 'ZZ09_Palladium',
                'exponent'    => 'N.A.'
            ],
            'XPF' => [
                'name'        => 'CFP Franc',
                'code'        => '953',
                'country'     => 'WALLIS AND FUTUNA',
                'exponent'    => '0'
            ],
            'XPT' => [
                'name'        => 'Platinum',
                'code'        => '962',
                'country'     => 'ZZ10_Platinum',
                'exponent'    => 'N.A.'
            ],
            'XSU' => [
                'name'        => 'Sucre',
                'code'        => '994',
                'country'     => 'SISTEMA UNITARIO DE COMPENSACION REGIONAL DE PAGOS "SUCRE"',
                'exponent'    => 'N.A.'
            ],
            'XTS' => [
                'name'        => 'Codes specifically reserved for testing purposes',
                'code'        => '963',
                'country'     => 'ZZ06_Testing_Code',
                'exponent'    => 'N.A.'
            ],
            'XUA' => [
                'name'        => 'ADB Unit of Account',
                'code'        => '965',
                'country'     => 'MEMBER COUNTRIES OF THE AFRICAN DEVELOPMENT BANK GROUP',
                'exponent'    => 'N.A.'
            ],
            'XXX' => [
                'name'        => 'The codes assigned for transactions where no currency is involved',
                'code'        => '999',
                'country'     => 'ZZ07_No_Currency',
                'exponent'    => 'N.A.'
            ],
            'YER' => [
                'name'        => 'Yemeni Rial',
                'code'        => '886',
                'country'     => 'YEMEN',
                'exponent'    => '2'
            ],
            'ZAR' => [
                'name'        => 'Rand',
                'code'        => '710',
                'country'     => 'SOUTH AFRICA',
                'exponent'    => '2'
            ],
            'ZMW' => [
                'name'        => 'Zambian Kwacha',
                'code'        => '967',
                'country'     => 'ZAMBIA',
                'exponent'    => '2'
            ],
            'ZWL' => [
                'name'        => 'Zimbabwe Dollar',
                'code'        => '932',
                'country'     => 'ZIMBABWE',
                'exponent'    => '2'
            ]
        ];

    /**
     * Convert amount to ISO-4217 minor currency unit
     *
     * @param $amount - amount to convert
     * @param $iso    - iso code of the currency
     *
     * @return mixed  - using string as we don't want to cast it without knowing how much precision
     *                is required
     * @throws InvalidArgument
     */
    public static function amountToExponent($amount, $iso)
    {
        $exp = self::fetchCurrencyExponent($iso);

        if (is_null($exp)) {
            return strval($amount);
        }

        self::validateCurrencyExponent($amount, $exp, $iso);
        return ($exp > 0) ? bcmul($amount, pow(10, $exp), 0) : strval($amount);
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
        $exp = self::fetchCurrencyExponent($iso);

        if (is_null($exp)) {
            return strval($amount);
        }

        return ($exp > 0) ? bcdiv($amount, pow(10, $exp), $exp) : strval($amount);
    }

    /**
     * Retrieves a list with all supported currencies
     *
     * @return array
     */
    public static function getList()
    {
        return \Genesis\Utils\Common::getArrayKeys(self::$iso4217);
    }

    /**
     * Retrieve a random currency from the currencies list
     *
     * @return string
     */
    public static function getRandomCurrency()
    {
        $currencies = static::getList();
        $lastIndex  = count($currencies) - 1;

        return $currencies[mt_rand(0, $lastIndex)];
    }

    /**
     * @param mixed $amount
     * @param int $exp
     * @param string $currency
     * @return void
     * @throws InvalidArgument
     */
    public static function validateCurrencyExponent($amount, $exp, $currency)
    {
        $parts = explode('.', $amount);
        if (!empty($parts[1]) && mb_strlen($parts[1]) > $exp) {
            throw new InvalidArgument(
                sprintf(
                    'Currency %s exponent %s does not match the given amount %s',
                    $currency,
                    self::$iso4217[$currency]['exponent'],
                    $amount
                )
            );
        }
    }

    /**
     * @param string $currencyCode
     * @return int|null
     */
    public static function fetchCurrencyExponent($currencyCode)
    {
        $currencyCode = strtoupper($currencyCode);
        return (array_key_exists($currencyCode, self::$iso4217))
            ? intval(self::$iso4217[$currencyCode]['exponent'])
            : null;
    }
}

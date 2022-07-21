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

namespace Genesis\API\Constants\Transaction;

use Genesis\API\Constants\NonFinancial\Services;
use Genesis\Utils\Common;

/**
 * Class Names
 *
 * Contain names of all transaction types
 * Used for visualization purposes
 *
 * @package Genesis\API\Constants\Transaction
 */
class Names
{
    /**
     * @var array $names
     */
    private static $names = [
        Services::AVS                  => 'AVS',
        Types::ABNIDEAL                => 'ABN iDeal',
        Types::ACCOUNT_VERIFICATION    => 'Account Verification',
        Types::AFRICAN_MOBILE_PAYOUT   => 'African Mobile Payout',
        Types::AFRICAN_MOBILE_SALE     => 'African Mobile Sale',
        Types::ALIPAY                  => 'Alipay',
        Types::APPLE_PAY               => 'Apple pay',
        Types::ARGENCARD               => 'Argencard',
        Types::ASTROPAY_CARD           => 'Astropay Card',
        Types::ASTROPAY_DIRECT         => 'Astropay Direct',
        Types::AURA                    => 'Aura',
        Types::AUTHORIZE               => 'Authorize',
        Types::AUTHORIZE_3D            => 'Authorize (3D-Secure)',
        Types::BALOTO                  => 'Baloto',
        Types::BANAMEX                 => 'Banamex',
        Types::BANCOMER                => 'Bancomer',
        Types::BANCONTACT              => 'Bancontact',
        Types::BANCO_DE_OCCIDENTE      => 'Banco de Occidente',
        Types::BANCO_DO_BRASIL         => 'Banco do Brasil',
        Types::BITPAY_PAYOUT           => 'BitPay Payout',
        Types::BITPAY_REFUND           => 'BitPay Refund',
        Types::BITPAY_SALE             => 'BitPay Sale',
        Types::BOLETO                  => 'Boleto',
        Types::BRADESCO                => 'Bradesco',
        Types::CABAL                   => 'Cabal',
        Types::CAPTURE                 => 'Capture',
        Types::CARULLA                 => 'Carulla',
        Types::CASHU                   => 'CashU',
        Types::CENCOSUD                => 'Cencosud',
        Types::CITADEL_PAYIN           => 'Citadel PayIn',
        Types::CITADEL_PAYOUT          => 'Citadel PayOut',
        Types::CREDIT                  => 'Credit',
        Types::DAVIVIENDA              => 'Davivienda',
        Types::EARTHPORT               => 'Earthport',
        Types::EFECTY                  => 'Efecty',
        Types::ELO                     => 'Elo',
        Types::EMPRESE_DE_ENERGIA      => 'Emprese de Energia',
        Types::ENTERCASH               => 'Entercash',
        Types::EPS                     => 'EPS',
        Types::EZEECARD_PAYOUT         => 'eZeeCard Payout',
        Types::EZEEWALLET              => 'eZeeWallet',
        Types::FASHIONCHEQUE           => 'Fashioncheque',
        Types::GIROPAY                 => 'GiroPay',
        Types::GOOGLE_PAY              => 'Google Pay',
        Types::HIPERCARD               => 'Hipercard',
        Types::IDEAL                   => 'iDeal',
        Types::IDEBIT_PAYIN            => 'iDebit PayIn',
        Types::IDEBIT_PAYOUT           => 'iDebit PayOut',
        Types::INCREMENTAL_AUTHORIZE   => 'Incremental Authorize',
        Types::INIT_RECURRING_SALE     => 'Init Recurring Sale',
        Types::INIT_RECURRING_SALE_3D  => 'Init Recurring Sale (3D-Secure)',
        Types::INPAY                   => 'INPay',
        Types::INSTANT_TRANSFER        => 'InstantTransfer',
        Types::INSTA_DEBIT_PAYIN       => 'InstaDebit PayIn',
        Types::INSTA_DEBIT_PAYOUT      => 'InstaDebit PayOut',
        Types::INTERSOLVE              => 'Intersolve',
        Types::ITAU                    => 'Itau',
        Types::KLARNA_AUTHORIZE        => 'Klarna Authorize',
        Types::KLARNA_CAPTURE          => 'Klarna Capture',
        Types::KLARNA_REFUND           => 'Klarna Refund',
        Types::MULTIBANCO              => 'Multibanco',
        Types::MY_BANK                 => 'My Bank',
        Types::NARANJA                 => 'Naranja',
        Types::NATIVA                  => 'Nativa',
        Types::NEOSURF                 => 'Neosurf',
        Types::NETELLER                => 'Neteller',
        Types::ONLINE_BANKING_PAYIN    => 'Online Banking',
        Types::ONLINE_BANKING_PAYOUT   => 'Bank Pay-out',
        Types::OXXO                    => 'OXXO',
        Types::P24                     => 'P24',
        Types::PAGO_FACIL              => 'Pago Facil',
        Types::PARTIAL_REVERSAL        => 'Partial Reversal',
        Types::PAYBYVOUCHER_SALE       => 'PayByVoucher Sale',
        Types::PAYBYVOUCHER_YEEPAY     => 'PayByVoucher Yeepay',
        Types::PAYOUT                  => 'Payout',
        Types::PAY_PAL                 => 'PayPal',
        Types::PAYPAL_EXPRESS          => 'PayPal Express Checkout',
        Types::PAYSAFECARD             => 'Paysafecard',
        Types::PAYU                    => 'PayU',
        Types::PIX                     => 'PIX',
        Types::POLI                    => 'POLi',
        Types::POST_FINANCE            => 'PostFinance',
        Types::PPRO                    => 'PPRO',
        Types::PSE                     => 'Pagos Seguros en Linea',
        Types::QIWI                    => 'QIWI',
        Types::RAPI_PAGO               => 'RapiPago',
        Types::RECURRING_SALE          => 'Recurring Sale',
        Types::RUSSIAN_MOBILE_SALE     => 'Russian Mobile Sale',
        Types::RUSSIAN_MOBILE_PAYOUT   => 'Russian Mobile Payout',
        Types::REDPAGOS                => 'Redpagos',
        Types::REFUND                  => 'Refund',
        Types::SAFETYPAY               => 'SafetyPay',
        Types::SALE                    => 'Sale',
        Types::SALE_3D                 => 'Sale (3D-Secure)',
        Types::SANTANDER               => 'Santander',
        Types::SANTANDER_CASH          => 'Santander Cash',
        Types::SCT_PAYOUT              => 'SCT Payout',
        Types::SDD_INIT_RECURRING_SALE => 'SDD Init Recurring Sale',
        Types::SDD_RECURRING_SALE      => 'SDD Recurring Sale',
        Types::SDD_REFUND              => 'SDD Refund',
        Types::SDD_SALE                => 'SDD Sale',
        Types::SOFORT                  => 'Sofort',
        Types::SURTIMAX                => 'Surtimax',
        Types::TARJETA_SHOPPING        => 'Tarjeta Shopping',
        Types::TCS                     => 'The Container Store',
        Types::TRANSFER_TO_PAYOUT      => 'TransferTo Payout',
        Types::TRUSTLY_SALE            => 'Trustly Sale',
        Types::TRUSTLY_WITHDRAWAL      => 'Trustly Withdrawal',
        Types::TRUSTPAY                => 'TrustPay',
        Types::UPI                     => 'Upi',
        Types::VOID                    => 'Void',
        Types::WEBMONEY                => 'WebMoney',
        Types::WEBPAY                  => 'Webpay',
        Types::WECHAT                  => 'Wechat',
        Types::ZIMPLER                 => 'Zimpler'
    ];

    /**
     * Return all Transaction Names in alphabetical order
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(
            Common::getSortedArrayByValue(
                self::$names
            )
        );
    }

    /**
     * Return Name of transaction type
     *
     * @param $transactionType
     * @return string
     */
    public static function getName($transactionType)
    {
        return array_key_exists($transactionType, self::$names) ?
            self::$names[$transactionType] : 'Unknown Transaction Type';
    }
}

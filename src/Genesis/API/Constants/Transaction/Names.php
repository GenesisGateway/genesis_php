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
        Types::ACCOUNT_VERIFICATION    => 'Account Verification',
        Types::AUTHORIZE               => 'Authorize',
        Types::AUTHORIZE_3D            => 'Authorize (3D-Secure)',
        Types::SALE                    => 'Sale',
        Types::SALE_3D                 => 'Sale (3D-Secure)',
        Types::CAPTURE                 => 'Capture',
        Types::REFUND                  => 'Refund',
        Types::VOID                    => 'Void',
        Types::CREDIT                  => 'Credit',
        Types::PAYOUT                  => 'Payout',
        Types::INIT_RECURRING_SALE     => 'Init Recurring Sale',
        Types::INIT_RECURRING_SALE_3D  => 'Init Recurring Sale (3D-Secure)',
        Types::RECURRING_SALE          => 'Recurring Sale',
        Types::ABNIDEAL                => 'ABN iDeal',
        Types::CASHU                   => 'CashU',
        Types::EZEEWALLET              => 'eZeeWallet',
        Types::NETELLER                => 'Neteller',
        Types::POLI                    => 'POLi',
        Types::WEBMONEY                => 'WebMoney',
        Types::PAYBYVOUCHER_YEEPAY     => 'PayByVoucher Yeepay',
        Types::PAYBYVOUCHER_SALE       => 'PayByVoucher Sale',
        Types::PAYSAFECARD             => 'Paysafecard',
        Types::PPRO                    => 'PPRO',
        Types::TRUSTPAY                => 'TrustPay',
        Types::MY_BANK                 => 'My Bank',
        Types::BANCONTACT              => 'Bancontact',
        Types::QIWI                    => 'QIWI',
        Types::IDEAL                   => 'iDeal',
        Types::EPS                     => 'EPS',
        Types::GIROPAY                 => 'GiroPay',
        Types::SOFORT                  => 'Sofort',
        Types::INPAY                   => 'INPay',
        Types::P24                     => 'P24',
        Types::TRUSTLY_SALE            => 'Trustly Sale',
        Types::TRUSTLY_WITHDRAWAL      => 'Trustly Withdrawal',
        Types::PAYPAL_EXPRESS          => 'PayPal Express Checkout',
        Types::SDD_SALE                => 'SDD Sale',
        Types::SCT_PAYOUT              => 'SCT Payout',
        Types::SDD_REFUND              => 'SDD Refund',
        Types::SDD_INIT_RECURRING_SALE => 'SDD Init Recurring Sale',
        Types::SDD_RECURRING_SALE      => 'SDD Recurring Sale',
        Types::IDEBIT_PAYIN            => 'iDebit PayIn',
        Types::IDEBIT_PAYOUT           => 'iDebit PayOut',
        Types::INSTA_DEBIT_PAYIN       => 'InstaDebit PayIn',
        Types::INSTA_DEBIT_PAYOUT      => 'InstaDebit PayOut',
        Types::CITADEL_PAYIN           => 'Citadel PayIn',
        Types::CITADEL_PAYOUT          => 'Citadel PayOut',
        Types::EARTHPORT               => 'Earthport',
        Types::ALIPAY                  => 'Alipay',
        Types::WECHAT                  => 'Wechat',
        Types::ONLINE_BANKING_PAYIN    => 'Online Banking',
        Types::ONLINE_BANKING_PAYOUT   => 'Bank Pay-out',
        Types::TCS                     => 'The Container Store',
        Types::FASHIONCHEQUE           => 'Fashioncheque',
        Types::INTERSOLVE              => 'Intersolve',
        Types::KLARNA_AUTHORIZE        => 'Klarna Authorize',
        Types::KLARNA_CAPTURE          => 'Klarna Capture',
        Types::KLARNA_REFUND           => 'Klarna Refund',
        Types::ZIMPLER                 => 'Zimpler',
        Types::BANCO_DO_BRASIL         => 'Banco do Brasil',
        Types::ENTERCASH               => 'Entercash',
        Types::INSTANT_TRANSFER        => 'InstantTransfer',
        Types::PAYU                    => 'PayU',
        Types::MULTIBANCO              => 'Multibanco',
        Types::BITPAY_SALE             => 'BitPay Sale',
        Types::BITPAY_REFUND           => 'BitPay Refund',
        Types::BITPAY_PAYOUT           => 'BitPay Payout',
        Types::BANCO_DE_OCCIDENTE      => 'Banco de Occidente',
        Types::BALOTO                  => 'Baloto',
        Types::BANAMEX                 => 'Banamex',
        Types::BOLETO                  => 'Boleto',
        Types::ASTROPAY_DIRECT         => 'Astropay Direct',
        Types::EMPRESE_DE_ENERGIA      => 'Emprese de Energia',
        Types::CARULLA                 => 'Carulla',
        Types::OXXO                    => 'OXXO',
        Types::PAGO_FACIL              => 'Pago Facil',
        Types::REDPAGOS                => 'Redpagos',
        Types::SANTANDER_CASH          => 'Santander Cash',
        Types::SURTIMAX                => 'Surtimax',
        Types::EFECTY                  => 'Efecty',
        Types::ARGENCARD               => 'Argencard',
        Types::AURA                    => 'Aura',
        Types::CENCOSUD                => 'Cencosud',
        Types::ELO                     => 'Elo',
        Types::HIPERCARD               => 'Hipercard',
        Types::CABAL                   => 'Cabal',
        Types::NARANJA                 => 'Naranja',
        Types::NATIVA                  => 'Nativa',
        Types::TARJETA_SHOPPING        => 'Tarjeta Shopping',
        Types::NEOSURF                 => 'Neosurf',
        Types::SAFETYPAY               => 'SafetyPay',
        Types::ITAU                    => 'Itau',
        Types::SANTANDER               => 'Santander',
        Types::BANCOMER                => 'Bancomer',
        Types::BRADESCO                => 'Bradesco',
        Types::ASTROPAY_CARD           => 'Astropay Card',
        Types::RAPI_PAGO               => 'RapiPago',
        Types::PSE                     => 'Pagos Seguros en Linea',
        Types::INCREMENTAL_AUTHORIZE   => 'Incremental Authorize',
        Types::PARTIAL_REVERSAL        => 'Partial Reversal',
        Types::EZEECARD_PAYOUT         => 'eZeeCard Payout',
        Types::TRANSFER_TO_PAYOUT      => 'TransferTo Payout',
        Types::DAVIVIENDA              => 'Davivienda',
        Types::WEBPAY                  => 'Webpay',
        Types::APPLE_PAY               => 'Apple pay'
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

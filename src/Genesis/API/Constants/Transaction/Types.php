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

/**
 * Class Types
 *
 * Transaction types of a Genesis Transaction
 *
 * @package Genesis\API\Constants\Transaction
 */
class Types
{
    /**
     * Address Verification
     */
    const AVS = 'avs';

    /**
     * Account Verification
     */
    const ACCOUNT_VERIFICATION = 'account_verification';

    /**
     * A standard Authorization
     */
    const AUTHORIZE = 'authorize';

    /**
     * 3D-Secure Authorization
     */
    const AUTHORIZE_3D = 'authorize3d';

    /**
     * A standard Sale
     */
    const SALE = 'sale';

    /**
     * 3D-Secure Sale
     */
    const SALE_3D = 'sale3d';

    /**
     * Capture settles a transaction which has been authorized before.
     */
    const CAPTURE = 'capture';

    /**
     * Refunds allow to return already billed amounts to customers.
     */
    const REFUND = 'refund';

    /**
     * Void transactions undo previous transactions.
     */
    const VOID = 'void';

    /**
     * Credits (also known as Credit Fund Transfer a.k.a. CFT)
     */
    const CREDIT = 'credit';

    /**
     * Payouts transactions
     */
    const PAYOUT = 'payout';

    /**
     * A standard initial recurring
     */
    const INIT_RECURRING_SALE = 'init_recurring_sale';

    /**
     * 3D-based initial recurring
     */
    const INIT_RECURRING_SALE_3D = 'init_recurring_sale3d';

    /**
     * A RecurringSale transaction is a "repeated" transaction which follows and references an initial transaction
     */
    const RECURRING_SALE = 'recurring_sale';

    /**
     * Bank transfer, popular in Netherlands (via ABN)
     */
    const ABNIDEAL = 'abn_ideal';

    /**
     * Voucher-based payment
     */
    const CASHU = 'cashu';

    /**
     * Wallet-based payment
     */
    const EZEEWALLET = 'ezeewallet';

    /**
     * Neteller
     */
    const NETELLER = 'neteller';

    /**
     * POLi is Australia's most popular online real time debit payment system.
     */
    const POLI = 'poli';

    /**
     * WebMoney is a global settlement system and environment for online business activities.
     */
    const WEBMONEY = 'webmoney';

    /**
     * PayByVouchers via oBeP
     */
    const PAYBYVOUCHER_YEEPAY = 'paybyvoucher_yeepay';

    /**
     * PayByVouchers via Credit/Debit Cards
     */
    const PAYBYVOUCHER_SALE = 'paybyvoucher_sale';

    /**
     * Voucher-based payment
     */
    const PAYSAFECARD = 'paysafecard';

    /**
     * Supports payments via EPS, TeleIngreso, SafetyPay, TrustPay, ELV, Przelewy24, QIWI, and GiroPay
     */
    const PPRO = 'ppro';

    /**
     * Bank transfer payment, popular in Germany
     */
    const SOFORT = 'sofort';

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @return bool
     */
    public static function isValidTransactionType($type)
    {
        $transactionTypesList = array(
            self::AVS,
            self::ACCOUNT_VERIFICATION,
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::SALE,
            self::SALE_3D,
            self::CAPTURE,
            self::REFUND,
            self::VOID,
            self::CREDIT,
            self::PAYOUT,
            self::INIT_RECURRING_SALE,
            self::INIT_RECURRING_SALE_3D,
            self::RECURRING_SALE,
            self::ABNIDEAL,
            self::CASHU,
            self::EZEEWALLET,
            self::NETELLER,
            self::POLI,
            self::WEBMONEY,
            self::PAYBYVOUCHER_YEEPAY,
            self::PAYBYVOUCHER_SALE,
            self::PAYSAFECARD,
            self::PPRO,
            self::SOFORT
        );

        if (in_array($type, $transactionTypesList)) {
            return true;
        }

        return false;
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @return bool
     */
    public static function isPayByVoucher($type)
    {
        $transactionTypesList = array(
            self::PAYBYVOUCHER_YEEPAY,
            self::PAYBYVOUCHER_SALE,
        );

        if (in_array($type, $transactionTypesList)) {
            return true;
        }

        return false;
    }

    /**
     * Get custom required parameters with values per transaction
     * @param string $type
     * @return array|bool
     */
    public static function getCustomRequiredParameters($type)
    {
        switch ($type) {
            case self::PPRO:
                return array(
                    'payment_method' =>
                        \Genesis\API\Constants\Payment\Methods::getMethods()
                );
                break;

            case self::PAYBYVOUCHER_SALE:
            case self::PAYBYVOUCHER_YEEPAY:
                $customParameters = array(
                    'card_type'   =>
                        \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\CardTypes::getCardTypes(),
                    'redeem_type' =>
                        \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\RedeemTypes::getRedeemTypes()
                );

                if ($type == self::PAYBYVOUCHER_YEEPAY) {
                    $customParameters = array_merge($customParameters, array(
                        'product_name'     => null,
                        'product_category' => null
                    ));
                }

                return $customParameters;
                break;

            default:
                return false;
        }
    }
}

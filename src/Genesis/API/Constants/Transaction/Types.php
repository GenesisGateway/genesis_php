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
     * Global payment system, that makes instant cross-border payments more secure, regulated by Danish and Swiss FSA
     */
    const INPAY = 'inpay';

    /**
     * P24 is an online banking payment, popular in Poland
     */
    const P24 = 'p24';

    /**
     * Trustly is a fast and secure oBeP-style alternative payment method. It is free of charge and
     * allows you to deposit money directly from your online bank account.
     */
    const TRUSTLY_SALE = 'trustly_sale';

    /**
     * Trustly is an oBeP-style alternative payment method that allows you to
     * withdraw money directly from your online bank account using your bank credentials.
     */
    const TRUSTLY_WITHDRAWAL = 'trustly_withdrawal';

    /**
     * PayPal Express Checkout is a fast, easy way for buyers to pay with PayPal.
     * Express Checkout eliminates one of the major causes of checkout abandonment by giving buyers
     * all the transaction details at once, including order details, shipping options, insurance choices, and tax totals
     */
    const PAYPAL_EXPRESS = 'paypal_express';

    /**
     * Sepa Direct Debit Payment, popular in Germany.
     * Single Euro Payments Area (SEPA) allows consumers to make cashless Euro payments to
     * any beneficiary located anywhere in the Euro area using only a single bank account
     */
    const SDD_SALE = 'sdd_sale';

    /**
     * Sepa Direct Debit Payout, popular in Germany.
     * Processed as a SEPA CreditTransfer and can be used for all kind of payout services
     * across the EU with 1 day settlement. Suitable for Gaming, Forex-Binaries, Affiliate Programs or Merchant payouts
     */
    const SDD_PAYOUT = 'sdd_payout';

    /**
     * Sepa Direct Debit Refund Transaction.
     * Refunds allow to return already billed amounts to customers.
     */
    const SDD_REFUND = 'sdd_refund';

    /**
     * Sepa Direct Debit initial recurring
     */
    const SDD_INIT_RECURRING_SALE = 'sdd_init_recurring_sale';

    /**
     * Sepa Direct Debit RecurringSale transaction is a "repeated" transaction,
     * which follows and references an SDD initial transaction
     */
    const SDD_RECURRING_SALE = 'sdd_recurring_sale';

    /**
     * iDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real-time payments without a credit card.
     * Using iDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * iDebit Payin is only asynchronous and uses eCheck.
     */
    const IDEBIT_PAYIN = 'idebit_payin';

    /**
     * iDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real-time payments without a credit card.
     * Using iDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * iDebit Payout is only synchronous and uses eCheck.
     */
    const IDEBIT_PAYOUT = 'idebit_payout';

    /**
     * InstaDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real- time payments without a credit card.
     * Using InstaDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * InstaDebit Payin is only asynchronous and uses online bank transfer.
     */
    const INSTA_DEBIT_PAYIN = 'insta_debit_payin';

    /**
     * InstaDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real- time payments without a credit card.
     * Using InstaDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * InstaDebit Payout is only synchronous and uses online bank transfer.
     */
    const INSTA_DEBIT_PAYOUT = 'insta_debit_payout';

    /**
     * Citadel is an oBeP-style alternative payment method.
     * It offers merchants the ability to send/receive consumer payments via the use of bank transfer functionality
     * available from the consumer’s online banking website.
     *
     * Payins are only asynchronous. After initiating a transaction the transaction status is set to pending async and
     * the consumer is redirected to Citadel’s Instant Banking website.
     */
    const CITADEL_PAYIN = 'citadel_payin';

    /**
     * Citadel is an oBeP-style alternative payment method.
     * It offers merchants the ability to send/receive consumer payments via the use of bank transfer functionality
     * available from the consumer’s online banking website.
     *
     * The workflow for Payouts is synchronous, there is no redirect to the Citadel’s Instant Banking website.
     * There are different required fields per country, e.g. IBAN and SWIFT Code or Account Number and Branch Code
     */
    const CITADEL_PAYOUT = 'citadel_payout';

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     * @return bool
     */
    public static function isValidTransactionType($type)
    {
        $transactionTypes = \Genesis\Utils\Common::getClassConstants(__CLASS__);

        return in_array(strtolower($type), $transactionTypes);
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     * @return bool
     */
    public static function isPayByVoucher($type)
    {
        $transactionTypesList = [
            self::PAYBYVOUCHER_YEEPAY,
            self::PAYBYVOUCHER_SALE
        ];

        return in_array($type, $transactionTypesList);
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
                return [
                    'payment_method' => \Genesis\API\Constants\Payment\Methods::getMethods()
                ];
                break;

            case self::PAYBYVOUCHER_SALE:
            case self::PAYBYVOUCHER_YEEPAY:
                $customParameters = [
                    'card_type'   =>
                        \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\CardTypes::getCardTypes(),
                    'redeem_type' =>
                        \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\RedeemTypes::getRedeemTypes()
                ];

                if ($type == self::PAYBYVOUCHER_YEEPAY) {
                    $customParameters = array_merge(
                        $customParameters,
                        [
                            'product_name'     => null,
                            'product_category' => null
                        ]
                    );
                }

                return $customParameters;
                break;

            default:
                return false;
        }
    }
}

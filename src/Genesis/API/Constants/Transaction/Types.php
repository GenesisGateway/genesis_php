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
     * Wallet-based payment
     */
    const EZEEWALLET = 'ezeewallet';

    /**
     * Bank transfer payment, popular in Germany
     */
    const SOFORT = 'sofort';

    /**
     * Bank transfer, popular in Netherlands
     */
    const SOFORT_IDEAL = 'sofort_ideal';

    /**
     * Voucher-based payment
     */
    const CASHU = 'cashu';

    /**
     * Voucher-based payment
     */
    const PAYSAFECARD = 'paysafecard';

    /**
     * Supports payments via EPS, TeleIngreso, SafetyPay, TrustPay, ELV, Przelewy24, QIWI, and GiroPay
     */
    const PPRO = 'ppro';

    /**
     * Bank transfer, popular in China
     */
    const PAYBYVOUCHER = 'paybyvoucher';

    /**
     * Account Verification
     */
    const ACCOUNT_VERIFICATION = 'account_verification';

    /**
     * Address Verification
     */
    const AVS = 'avs';
}

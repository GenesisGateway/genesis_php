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
 * Class States
 *
 * Transaction states of a Genesis Transaction
 *
 * @package Genesis\API\Constants\Transaction
 */
class States
{
    /**
     * Transaction was approved by the schemes and is successful.
     */
    const APPROVED = 'approved';

    /**
     * Transaction was declined by the schemes or risk management.
     */
    const DECLINED = 'declined';

    /**
     * The outcome of the transaction could not be determined, e.g. at a timeout situation.
     *
     * Transaction state will eventually change, so make a reconcile after a certain time frame.
     */
    const PENDING = 'pending';

    /**
     * An asynchronous transaction (3-D secure payment) has been initiated and is waiting for user
     * input.
     *
     * Updates of this state will be sent to the notification url specified in request.
     */
    const PENDING_ASYNC = 'pending_async';

    /**
     * An error has occurred while negotiating with the schemes.
     */
    const ERROR = 'error';

    /**
     * WPF initial status
     */
    const NEW_STATUS = 'new';

    /**
     * Once an approved transaction is refunded the state changes to refunded.
     */
    const REFUNDED = 'refunded';

    /**
     * Once an approved transaction is chargeback the state changes to change- backed.
     *
     * Chargeback is the state of rejecting an accepted transaction (with funds transferred)
     * by the cardholder or the issuer
     */
    const CHARGEBACKED = 'chargebacked';

    /**
     * Once a chargebacked transaction is charged, the state changes to charge- back reversed.
     *
     * Chargeback has been canceled.
     */
    const CHARGEBACK_REVERSED = 'chargeback_reversed';

    /**
     * Once a chargeback reversed transaction is chargebacked the state changes to pre arbitrated.
     */
    const PRE_ARBITRATED = 'pre_arbitrated';

    /**
     * Transaction was authorized, but later the merchant canceled it.
     */
    const VOIDED = 'voided';
}

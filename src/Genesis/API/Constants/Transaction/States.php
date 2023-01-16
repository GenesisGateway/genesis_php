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
namespace Genesis\API\Constants\Transaction;

use Genesis\Exceptions\InvalidMethod;

/**
 * Class States
 *
 * Transaction states of a Genesis Transaction
 *
 * @package Genesis\API\Constants\Transaction
 *
 * @method bool isApproved()
 * @method bool isDeclined()
 * @method bool isPending()
 * @method bool isPendingAsync()
 * @method bool isError()
 * @method bool isRefunded()
 * @method bool isVoided()
 * @method bool isEnabled()
 * @method bool isDisabled()
 * @method bool isSuccess()
 * @method bool isSubmitted()
 * @method bool isPendingHold()
 * @method bool isSecondChargebacked()
 * @method bool isRepresented()
 * @method bool isInProgress()
 * @method bool isUnsuccessful()
 * @method bool isNew()
 * @method bool isUser()
 * @method bool isTimeout()
 * @method bool isChargebacked()
 * @method bool isChargebackReversed()
 * @method bool isPreArbitrated()
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
     * Transaction is in-progress
     */
    const IN_PROGRESS = 'in_progress';

    /**
     * Once an approved transaction is refunded the state changes to refunded.
     */
    const REFUNDED = 'refunded';

    /**
     * Transaction was authorized, but later the merchant canceled it.
     */
    const VOIDED = 'voided';

    /**
     * An error has occurred while negotiating with the schemes.
     */
    const ERROR = 'error';

    /**
     * Transaction failed, but it was not declined
     */
    const UNSUCCESSFUL = 'unsuccessful';

    /**
     * WPF initial status
     */
    const NEW_STATUS = 'new';

    /**
     * WPF in-progress status
     */
    const USER = 'user';

    /**
     * WPF timeout has occurred
     */
    const TIMEOUT = 'timeout';

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
     * Status of the consumer from Consumer API
     */
    const ENABLED = 'enabled';

    /**
     * Status of the consumer from Consumer API
     */
    const DISABLED = 'disabled';

    /**
     * Transaction API success status
     */
    const SUCCESS = 'success';

    /**
     * WPF status represent submitted form
     */
    const SUBMITTED = 'submitted';

    /**
     * An asynchronous transaction has been finalized by user but is waiting final update from provider.
     */
    const PENDING_HOLD = 'pending_hold';

    /**
     * Once a chargeback_reversed/represented transaction is chargebacked the state changes to second chargebacked.
     */
    const SECOND_CHARGEBACKED = 'second_chargebacked';

    /**
     * Once a chargebacked transaction is charged, the state changes to represented. Chargeback has been canceled.
     */
    const REPRESENTED = 'represented';

    /**
     * Store the state of transaction for comparison
     *
     * @var string
     */
    private $status;

    /**
     * Set the status if one is being passed
     *
     * @param $status
     */
    public function __construct($status = null)
    {
        if (!is_null($status)) {
            $this->status = trim($status);
        }
    }

    /**
     * Handle "magic" calls
     *
     * @param $method
     * @param $args
     *
     * @throws InvalidMethod
     * @return bool
     */
    public function __call($method, $args)
    {
        list($action, $target) = \Genesis\Utils\Common::resolveDynamicMethod($method);

        switch ($action) {
            case 'is':
                if (isset($this->status)) {
                    return $this->compare($target);
                }
        }

        throw new InvalidMethod(
            sprintf(
                'You\'re trying to call a non-existent method %s of class %s!',
                $method,
                __CLASS__
            )
        );
    }

    /**
     * Check if the status is the same passed as parameter
     *
     * @param $subject
     *
     * @return bool
     */
    public function compare($subject)
    {
        $subject = $this->getStateAliasConstantName($subject);

        return $this->status == constant('self::' . strtoupper($subject));
    }

    /**
     * Check whether this is a valid (known) status
     *
     * @return bool
     */
    public function isValid()
    {
        $statusList = \Genesis\Utils\Common::getClassConstants(__CLASS__);

        return in_array(strtolower($this->status), $statusList);
    }

    /**
     * Check for the alias of the state for building a proper constant's comparison call
     *
     * @param $state
     * @return mixed|string
     */
    private function getStateAliasConstantName($state)
    {
        $subject = $state;
        $alias   = [
            self::NEW_STATUS => 'new_status'
        ];

        if (array_key_exists($state, $alias)) {
            $subject = $alias[$state];
        }

        return $subject;
    }
}

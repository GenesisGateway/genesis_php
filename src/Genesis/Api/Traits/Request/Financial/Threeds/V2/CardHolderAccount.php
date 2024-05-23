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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\PasswordChangeIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\RegistrationIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\ShippingAddressUsageIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\SuspiciousActivityIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\UpdateIndicators;

/**
 * Trait CardHolderAccount
 * @package Genesis\Api\Traits\Request\Financial\Threeds\V2
 *
 * @codingStandardsIgnoreStart
 * @method string getThreedsV2CardHolderAccountUpdateIndicator()                     Length of time since the cardholder’s account information with the 3DS Requester was last changed
 * @method $this  setThreedsV2CardHolderAccountUpdateIndicator($value)               Length of time since the cardholder’s account information with the 3DS Requester was last changed
 * @method string getThreedsV2CardHolderAccountPasswordChangeIndicator()             Length of time since the cardholder account with the 3DS Requester had a password change or account reset
 * @method $this  setThreedsV2CardHolderAccountPasswordChangeIndicator($value)       Length of time since the cardholder account with the 3DS Requester had a password change or account reset
 * @method string getThreedsV2CardHolderAccountShippingAddressUsageIndicator()       Indicates when the shipping address used for this transaction was first used with the 3DS Requester
 * @method $this  setThreedsV2CardHolderAccountShippingAddressUsageIndicator($value) Indicates when the shipping address used for this transaction was first used with the 3DS Requester
 * @method int    getThreedsV2CardHolderAccountTransactionsActivityLast24Hours()     Number of transactions (successful and abandoned) for this cardholder account
 * @method int    getThreedsV2CardHolderAccountTransactionsActivityPreviousYear()    Number of transactions (successful and abandoned) for this cardholder account
 * @method int    getThreedsV2CardHolderAccountProvisionAttemptsLast24Hours()        Number of Add Card attempts in the last 24 hours
 * @method int    getThreedsV2CardHolderAccountPurchasesCountLast6Months()           Number of purchases with this cardholder account during the previous six months
 * @method string getThreedsV2CardHolderAccountSuspiciousActivityIndicator()         Indicates whether the 3DS Requester has experienced suspicious activity (including previous fraud)
 * @method $this  setThreedsV2CardHolderAccountSuspiciousActivityIndicator($value)   Indicates whether the 3DS Requester has experienced suspicious activity (including previous fraud)
 * @method string getThreedsV2CardHolderAccountRegistrationIndicator()               Indicates the length of time that the payment account was enrolled in the cardholder’s account with the 3DS Requester
 * @method $this  setThreedsV2CardHolderAccountRegistrationIndicator($value)         Indicates the length of time that the payment account was enrolled in the cardholder’s account with the 3DS Requester
 * @codingStandardsIgnoreEnd
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
trait CardHolderAccount
{
    /**
     * Date that the cardholder opened the account with the 3DS Requester.
     *
     * @var \DateTime $threeds_v2_card_holder_account_creation_date
     */
    protected $threeds_v2_card_holder_account_creation_date;

    /**
     * Length of time since the cardholder’s account information with the 3DS Requester was last changed
     *
     * @var string $threeds_v2_card_holder_account_update_indicator
     */
    protected $threeds_v2_card_holder_account_update_indicator;

    /**
     * Date that the cardholder’s account with the 3DS Requester was last changed
     *
     * @var \DateTime $threeds_v2_card_holder_account_last_change_date
     */
    protected $threeds_v2_card_holder_account_last_change_date;

    /**
     * Length of time since the cardholder account with the 3DS Requester had a password change or account reset
     *
     * @var string $threeds_v2_card_holder_account_password_change_indicator
     */
    protected $threeds_v2_card_holder_account_password_change_indicator;

    /**
     * Date that cardholder’s account with the 3DS Requester had a password change or account reset
     *
     * @var \DateTime $threeds_v2_card_holder_account_password_change_date
     */
    protected $threeds_v2_card_holder_account_password_change_date;

    /**
     * Indicates when the shipping address used for this transaction was first used with the 3DS Requester
     *
     * @var string $threeds_v2_card_holder_account_shipping_address_usage_indicator
     */
    protected $threeds_v2_card_holder_account_shipping_address_usage_indicator;

    /**
     * Date when the shipping address used for this transaction was first used with the 3DS Requester
     *
     * @var \DateTime $threeds_v2_card_holder_account_shipping_address_date_first_used
     */
    protected $threeds_v2_card_holder_account_shipping_address_date_first_used;

    /**
     * Number of transactions (successful and abandoned) for this cardholder account with the
     * 3DS Requester across all payment accounts in the previous 24 hours.
     *
     * @var integer $threeds_v2_card_holder_account_transactions_activity_last24_hours
     */
    protected $threeds_v2_card_holder_account_transactions_activity_last24_hours;

    /**
     * Number of transactions (successful and abandoned) for this cardholder account with the
     * 3DS Requester across all payment accounts in the previous year.
     *
     * @var integer $threeds_v2_card_holder_account_transactions_activity_previous_year
     */
    protected $threeds_v2_card_holder_account_transactions_activity_previous_year;

    /**
     * Number of Add Card attempts in the last 24 hours
     *
     * @var integer $threeds_v2_card_holder_account_provision_attempts_last24_hours
     */
    protected $threeds_v2_card_holder_account_provision_attempts_last24_hours;

    /**
     * Number of purchases with this cardholder account during the previous six months
     *
     * @var integer $threeds_v2_card_holder_account_purchases_count_last6_months
     */
    protected $threeds_v2_card_holder_account_purchases_count_last6_months;

    /**
     * Indicates whether the 3DS Requester has experienced suspicious activity (including previous fraud)
     * on the cardholder account
     *
     * @var string $threeds_v2_card_holder_account_suspicious_activity_indicator
     */
    protected $threeds_v2_card_holder_account_suspicious_activity_indicator;

    /**
     * Indicates the length of time that the payment account was enrolled in the cardholder’s
     * account with the 3DS Requester.
     *
     * @var string $threeds_v2_card_holder_account_registration_indicator
     */
    protected $threeds_v2_card_holder_account_registration_indicator;

    /**
     * Date that the payment account was enrolled in the cardholder’s account with the 3DS Requester
     *
     * @var \DateTime $threeds_v2_card_holder_account_registration_date
     */
    protected $threeds_v2_card_holder_account_registration_date;

    /**
     * Date that the cardholder opened the account with the 3DS Requester.
     *
     * @return string|null
     */
    public function getThreedsV2CardHolderAccountCreationDate()
    {
        return empty($this->threeds_v2_card_holder_account_creation_date) ? null :
            $this->threeds_v2_card_holder_account_creation_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * Date that the cardholder opened the account with the 3DS Requester.
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setThreedsV2CardHolderAccountCreationDate($value)
    {
        if (is_null($value)) {
            $this->threeds_v2_card_holder_account_creation_date = null;

            return $this;
        }

        return $this->parseDate(
            'threeds_v2_card_holder_account_creation_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid date.'
        );
    }

    /**
     * Date that the cardholder’s account with the 3DS Requester was last changed
     *
     * @return string|null
     */
    public function getThreedsV2CardHolderAccountLastChangeDate()
    {
        return empty($this->threeds_v2_card_holder_account_last_change_date) ? null :
            $this->threeds_v2_card_holder_account_last_change_date->format(
                DateTimeFormat::DD_MM_YYYY_L_HYPHENS
            );
    }

    /**
     * Date that the cardholder’s account with the 3DS Requester was last changed
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setThreedsV2CardHolderAccountLastChangeDate($value)
    {
        if (is_null($value)) {
            $this->threeds_v2_card_holder_account_last_change_date = null;

            return $this;
        }

        return $this->parseDate(
            'threeds_v2_card_holder_account_last_change_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid date.'
        );
    }

    /**
     * Date that cardholder’s account with the 3DS Requester had a password change or account reset
     *
     * @return string|null
     */
    public function getThreedsV2CardHolderAccountPasswordChangeDate()
    {
        return (empty($this->threeds_v2_card_holder_account_password_change_date)) ? null :
            $this->threeds_v2_card_holder_account_password_change_date->format(
                DateTimeFormat::DD_MM_YYYY_L_HYPHENS
            );
    }

    /**
     * Date that cardholder’s account with the 3DS Requester had a password change or account reset
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setThreedsV2CardHolderAccountPasswordChangeDate($value)
    {
        if (is_null($value)) {
            $this->threeds_v2_card_holder_account_password_change_date = null;

            return $this;
        }

        return $this->parseDate(
            'threeds_v2_card_holder_account_password_change_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid date.'
        );
    }

    /**
     * Date when the shipping address used for this transaction was first used with the 3DS Requester
     *
     * @return string|null
     */
    public function getThreedsV2CardHolderAccountShippingAddressDateFirstUsed()
    {
        return empty($this->threeds_v2_card_holder_account_shipping_address_date_first_used) ? null :
            $this->threeds_v2_card_holder_account_shipping_address_date_first_used->format(
                DateTimeFormat::DD_MM_YYYY_L_HYPHENS
            );
    }

    /**
     * Date when the shipping address used for this transaction was first used with the 3DS Requester
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setThreedsV2CardHolderAccountShippingAddressDateFirstUsed($value)
    {
        if (is_null($value)) {
            $this->threeds_v2_card_holder_account_shipping_address_date_first_used = null;

            return $this;
        }

        return $this->parseDate(
            'threeds_v2_card_holder_account_shipping_address_date_first_used',
            DateTimeFormat::getAll(),
            $value,
            'Invalid date.'
        );
    }

    /**
     * Date that the payment account was enrolled in the cardholder’s account with the 3DS Requester
     *
     * @return string|null
     */
    public function getThreedsV2CardHolderAccountRegistrationDate()
    {
        return empty($this->threeds_v2_card_holder_account_registration_date) ? null :
            $this->threeds_v2_card_holder_account_registration_date->format(
                DateTimeFormat::DD_MM_YYYY_L_HYPHENS
            );
    }

    /**
     * Date that the payment account was enrolled in the cardholder’s account with the 3DS Requester
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setThreedsV2CardHolderAccountRegistrationDate($value)
    {
        if (is_null($value)) {
            $this->threeds_v2_card_holder_account_registration_date = null;

            return $this;
        }

        return $this->parseDate(
            'threeds_v2_card_holder_account_registration_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid date.'
        );
    }

    /**
     * Number of transactions (successful and abandoned) for this cardholder account
     *
     * @param int $value
     * @return $this
     */
    public function setThreedsV2CardHolderAccountTransactionsActivityLast24Hours($value)
    {
        $this->threeds_v2_card_holder_account_transactions_activity_last24_hours = (int) $value;

        return $this;
    }

    /**
     * Number of transactions (successful and abandoned) for this cardholder account
     *
     * @param int $value
     * @return $this
     */
    public function setThreedsV2CardHolderAccountTransactionsActivityPreviousYear($value)
    {
        $this->threeds_v2_card_holder_account_transactions_activity_previous_year = (int) $value;

        return $this;
    }

    /**
     * Number of Add Card attempts in the last 24 hours
     *
     * @param int $value
     * @return $this
     */
    public function setThreedsV2CardHolderAccountProvisionAttemptsLast24Hours($value)
    {
        $this->threeds_v2_card_holder_account_provision_attempts_last24_hours = (int) $value;

        return $this;
    }

    /**
     * Number of purchases with this cardholder account during the previous six months
     *
     * @param int $value
     * @return $this
     */
    public function setThreedsV2CardHolderAccountPurchasesCountLast6Months($value)
    {
        $this->threeds_v2_card_holder_account_purchases_count_last6_months = (int) $value;

        return $this;
    }

    /**
     * @return array
     */
    protected function getCardHolderAccountValidations()
    {
        return [
            'threeds_v2_card_holder_account_update_indicator' => [
                $this->threeds_v2_card_holder_account_update_indicator => [
                    ['threeds_v2_card_holder_account_update_indicator' => UpdateIndicators::getAll()]
                ]
            ],
            'threeds_v2_card_holder_account_password_change_indicator' => [
                $this->threeds_v2_card_holder_account_password_change_indicator => [
                    ['threeds_v2_card_holder_account_password_change_indicator' => PasswordChangeIndicators::getAll()]
                ]
            ],
            'threeds_v2_card_holder_account_shipping_address_usage_indicator' => [
                $this->threeds_v2_card_holder_account_shipping_address_usage_indicator => [
                    [
                        'threeds_v2_card_holder_account_shipping_address_usage_indicator' =>
                            ShippingAddressUsageIndicators::getAll()
                    ]
                ]
            ],
            'threeds_v2_card_holder_account_suspicious_activity_indicator' => [
                $this->threeds_v2_card_holder_account_suspicious_activity_indicator => [
                    [
                        'threeds_v2_card_holder_account_suspicious_activity_indicator' =>
                            SuspiciousActivityIndicators::getAll()
                    ]
                ]
            ],
            'threeds_v2_card_holder_account_registration_indicator' => [
                $this->threeds_v2_card_holder_account_registration_indicator => [
                    ['threeds_v2_card_holder_account_registration_indicator' => RegistrationIndicators::getAll()]
                ]
            ]
        ];
    }

    /**
     * Get the Card Holder Account Attributes
     *
     * @return array
     */
    protected function getCardHolderAccountAttributes()
    {
        return [
            'creation_date'                       => $this->getThreedsV2CardHolderAccountCreationDate(),
            'update_indicator'                    => $this->getThreedsV2CardHolderAccountUpdateIndicator(),
            'last_change_date'                    => $this->getThreedsV2CardHolderAccountLastChangeDate(),
            'password_change_indicator'           => $this->getThreedsV2CardHolderAccountPasswordChangeIndicator(),
            'password_change_date'                => $this->getThreedsV2CardHolderAccountPasswordChangeDate(),
            'shipping_address_usage_indicator'    =>
                $this->getThreedsV2CardHolderAccountShippingAddressUsageIndicator(),
            'shipping_address_date_first_used'    => $this->getThreedsV2CardHolderAccountShippingAddressDateFirstUsed(),
            'transactions_activity_last_24_hours' =>
                $this->getThreedsV2CardHolderAccountTransactionsActivityLast24Hours(),
            'transactions_activity_previous_year' =>
                $this->getThreedsV2CardHolderAccountTransactionsActivityPreviousYear(),
            'provision_attempts_last_24_hours'    => $this->getThreedsV2CardHolderAccountProvisionAttemptsLast24Hours(),
            'purchases_count_last_6_months'       => $this->getThreedsV2CardHolderAccountPurchasesCountLast6Months(),
            'suspicious_activity_indicator'       => $this->getThreedsV2CardHolderAccountSuspiciousActivityIndicator(),
            'registration_indicator'              => $this->getThreedsV2CardHolderAccountRegistrationIndicator(),
            'registration_date'                   => $this->getThreedsV2CardHolderAccountRegistrationDate()
        ];
    }
}

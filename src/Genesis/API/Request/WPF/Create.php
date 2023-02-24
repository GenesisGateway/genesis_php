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
namespace Genesis\API\Request\WPF;

use Genesis\API\Constants\i18n;
use Genesis\API\Constants\Transaction\Parameters\ScaExemptions;
use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\Base\Financial\Cards\CreditCard;
use Genesis\API\Traits\Request\Financial\Cards\Recurring\RecurringTypeAttributes;
use Genesis\API\Traits\Request\Financial\Cards\Recurring\RecurringCategoryAttributes;
use Genesis\API\Traits\Request\Financial\PendingPaymentAttributes;
use Genesis\API\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\NotificationAttributes;
use Genesis\API\Traits\Request\Financial\Threeds\V2\WpfAttributes as WpfThreedsV2Attributes;
use Genesis\API\Traits\Request\RiskAttributes;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;
use Genesis\Utils\Common as CommonUtils;

/**
 * Web-Payment-Form Request
 *
 * @package    Genesis
 * @subpackage Request
 *
 * @codingStandardsIgnoreStart
 * @method $this  setTransactionId($value)    Set a Unique Transaction id
 * @method $this  setUsage($value)            Set the description of the transaction for later use
 * @method $this  setDescription($value)      Set a text describing the reason of the payment
 * @method $this  setReturnCancelUrl($value)  Set the  URL where the customer is sent to after they cancel the payment
 * @method $this  setConsumerId($value)       Saved cards will be listed for user to select
 * @method $this  setWebPaymentFormId($value) The unique ID of the web payment form configuration to be displayed for the current payment.
 * @method string getTransactionId()          Identifier of the transaction
 * @method string getUsage()                  Statement, as it appears in the customer’s bank statement
 * @method string getDescription()            A text describing the reason of the payment
 * @method string getReturnCancelUrl()        URL where the customer is sent to after they cancel the payment
 * @method bool   getRememberCard()           Offer the user the option to save cardholder details for future use (tokenize)
 * @method string getConsumerId()             Check documentation section Consumers and Tokenization. Saved cards will be listed for user to select
 * @method string getLifetime()               Number of minutes determining how long the WPF will be valid
 * @method string getReminders()              Settings for reminders sending when using the ’Pay Later’ feature
 * @method bool   getScaPreference()          Signifies whether to perform SCA on the transaction
 * @method string getScaExemption()           Exemption for the Strong Customer Authentication. The allowed options are low_value, low_risk
 * @method mixed  getWebPaymentFormId()       The unique ID of the web payment form configuration to be displayed for the current payment.
 * @codingStandardsIgnoreEnd
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Create extends \Genesis\API\Request
{
    use PaymentAttributes, AddressInfoAttributes, AsyncAttributes,
        NotificationAttributes, RiskAttributes, DescriptorAttributes,
        RestrictedSetter, BusinessAttributes, WpfThreedsV2Attributes,
        PendingPaymentAttributes, RecurringTypeAttributes, RecurringCategoryAttributes;

    const REMINDERS_CHANNEL_EMAIL      = 'email';
    const REMINDERS_CHANNEL_SMS        = 'sms';
    const MIN_ALLOWED_REMINDER_MINUTES = 1;
    const MAX_ALLOWED_REMINDER_DAYS    = 31;

    /**
     * Default Lifetime in minutes
     * Used when lifetime is not set
     */
    const DEFAULT_LIFETIME             = 30;

    /**
     * unique transaction id defined by merchant
     *
     * @var string $transaction_id
     */
    protected $transaction_id;

    /**
     * Statement, as it appears in the customer’s bank statement
     *
     * @var string $usage
     */
    protected $usage;

    /**
     * Check documentation section Tokenize. Offer the user the option to save
     * cardholder details for future use (tokenize).
     *
     * @var string $remember_card
     */
    protected $remember_card = false;

    /**
     * Check documentation section Consumers and Tokenization. Saved cards will be listed for user to select
     *
     * @var string $consumer_id
     */
    protected $consumer_id;

    /**
     * a text describing the reason of the payment
     *
     * e.g. "you’re buying concert tickets"
     *
     * @var string $description
     */
    protected $description;

    /**
     * URL where the customer is sent to after they cancel the payment
     *
     * @var string $return_cancel_url
     */
    protected $return_cancel_url;

    /**
     * Number of minutes determining how long the WPF will be valid.
     * Will be set to 30 minutes by default.
     * Valid value ranges between 1 minute and 31 days given in minutes
     *
     * @var int $lifetime
     */
    protected $lifetime = self::DEFAULT_LIFETIME;

    /**
     * Signifies whether the ’Pay Later’ feature would be enabled on the WPF
     *
     * @var bool $pay_later
     */
    protected $pay_later = false;

    /**
     * The language of reminders
     *
     * @var $reminder_language
     */
    protected $reminder_language;

    /**
     * Settings for reminders sending when using the ’Pay Later’ feature
     *
     * @var array $reminders
     */
    protected $reminders = [];

    /**
     * The transaction types that the merchant is willing to accept payments for
     *
     * @var array $transaction_types
     */
    protected $transaction_types = [];

    /**
     * Language code in ISO-639-1
     *
     * @var $language
     */
    protected $language;

    /**
     * Signifies whether to perform SCA on the transaction. At least one 3DS transaction type has to be submitted.
     *
     * @var bool $sca_preference
     */
    protected $sca_preference;

    /**
     * Exemption for the Strong Customer Authentication. The allowed options are low_value, low_risk
     *
     * @var string $sca_exemption
     */
    protected $sca_exemption;

    /**
     * The unique ID of the web payment form configuration to be displayed for the current payment.
     *
     * @var mixed $web_payment_form_id
     */
    protected $web_payment_form_id;

    /**
     * @param bool $flag
     *
     * @return Create
     */
    public function setRememberCard($flag)
    {
        $this->remember_card = (bool) $flag;

        return $this;
    }

    /**
     * Number of minutes determining how long the WPF will be valid.
     * Will be set to 30 minutes by default.
     * Valid value ranges between 1 minute and 31 days given in minutes
     * @param int $lifetime
     * @throws InvalidArgument
     * @return $this
     */
    public function setLifetime($lifetime)
    {
        $lifetime = intval($lifetime);

        if ($lifetime < 1 || $lifetime > 44640) {
            throw new InvalidArgument('Valid value ranges between 1 minute and 31 days given in minutes');
        }

        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * @param bool $flag
     *
     * @return Create
     */
    public function setPayLater($flag)
    {
        $this->pay_later = (bool) $flag;

        return $this;
    }

    public function setReminderLanguage($value)
    {
        // Strip the input down to two letters
        $language = Common::filterLanguageCode($value);

        $this->allowedOptionsSetter(
            'reminder_language',
            i18n::getAll(),
            $language,
            'Reminder Language value is not valid ISO-639-1 language code.'
        );

        $this->reminder_language = $language;

        return $this;
    }

    /**
     * @param $channel
     * @param $after
     *
     * @return Create
     * @throws ErrorParameter
     */
    public function addReminder($channel, $after)
    {
        if (count($this->reminders) === 3) {
            throw new ErrorParameter(
                'Maximum number of 3 allowed reminders reached. You can\'t add more reminders.'
            );
        }

        $after = (int) $after;

        if ($after < self::MIN_ALLOWED_REMINDER_MINUTES || $after > self::MAX_ALLOWED_REMINDER_DAYS * 24 * 60) {
            throw new ErrorParameter('After parameter must be between 1 minute and 31 days in minutes.');
        }

        $allowedChannels = [self::REMINDERS_CHANNEL_EMAIL, self::REMINDERS_CHANNEL_SMS];

        if (!in_array($channel, $allowedChannels)) {
            throw new ErrorParameter('Invalid channel value. Allowed are ' . implode(', ', $allowedChannels));
        }

        $this->reminders[] = [
            'reminder' => [
                'channel' => $channel,
                'after'   => $after
            ]
        ];

        return $this;
    }

    /**
     * Clears all reminders
     */
    public function clearReminders()
    {
        $this->reminders = [];
    }

    /**
     * @return array
     */
    protected function getRemindersStructure()
    {
        if ($this->pay_later === false) {
            return [];
        }

        return $this->reminders;
    }

    /**
     * Add transaction type to the list of available types
     *
     * @param string $name
     *
     * @param array  $parameters
     *
     * @return $this
     */
    public function addTransactionType($name, $parameters = [])
    {
        $this->verifyTransactionType($name, $parameters);

        $structure = [
            'transaction_type' => [
                '@attributes' => [
                    'name' => $name
                ],
                $parameters
            ]
        ];

        array_push($this->transaction_types, $structure);

        return $this;
    }

    /**
     * Signifies whether to perform SCA on the transaction
     *
     * @param mixed $value
     * @return Create
     */
    public function setScaPreference($value)
    {
        $this->sca_preference = CommonUtils::toBoolean($value);

        return $this;
    }

    /**
     * Exemption for the Strong Customer Authentication. The allowed options are low_value, low_risk
     *
     * @param string $value
     *
     * @return $this
     * @throws ErrorParameter
     */
    public function setScaExemption($value)
    {
        $scaExemptions = [ScaExemptions::EXEMPTION_LOW_VALUE, ScaExemptions::EXEMPTION_LOW_RISK];

        if (!in_array($value, $scaExemptions)) {
            throw new ErrorParameter(
                sprintf(
                    'Parameter Sca Exemption not valid! Use one of the following %s',
                    implode(', ', $scaExemptions)
                )
            );
        }

        $this->sca_exemption = $value;

        return $this;
    }

    /**
     * Verify that transaction type parameters are populated correctly
     *
     * @param string $transactionType
     * @param array $parameters
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyTransactionType($transactionType, $parameters = [])
    {
        if (!Types::isValidWPFTransactionType($transactionType)) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'Transaction type (%s) is not valid. Valid WPF transactions are: %s.',
                    $transactionType,
                    implode(', ', Types::getWPFTransactionTypes())
                )
            );
        }

        $txnCustomRequiredParams = Types::getCustomRequiredParameters(
            $transactionType
        );

        if (!CommonUtils::isValidArray($txnCustomRequiredParams)) {
            return;
        }

        $txnCustomRequiredParams = static::validateNativeCustomParameters($transactionType, $txnCustomRequiredParams);

        if (CommonUtils::isValidArray($txnCustomRequiredParams) && !CommonUtils::isValidArray($parameters)) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'Custom transaction parameters (%s) are required and none are set.',
                    implode(', ', array_keys($txnCustomRequiredParams))
                )
            );
        }

        foreach ($txnCustomRequiredParams as $customRequiredParam => $customRequiredParamValues) {
            $this->validateRequiredParameter(
                $transactionType,
                $customRequiredParam,
                $customRequiredParamValues,
                $parameters
            );
        }
    }

    /**
     * @param string $transactionType
     * @param array $txnCustomRequiredParams
     *
     * @return array
     */
    protected function validateNativeCustomParameters($transactionType, $txnCustomRequiredParams)
    {
        foreach ($txnCustomRequiredParams as $customRequiredParam => $customRequiredParamValues) {
            if (property_exists($this, $customRequiredParam)) {
                $this->validateRequiredParameter(
                    $transactionType,
                    $customRequiredParam,
                    $customRequiredParamValues,
                    [ $customRequiredParam => $this->{$customRequiredParam} ]
                );

                unset($txnCustomRequiredParams[$customRequiredParam]);
            }
        }

        return $txnCustomRequiredParams;
    }

    protected function validateRequiredParameter(
        $transactionType,
        $customRequiredParam,
        $customRequiredParamValues,
        $parameters
    ) {
        $this->checkEmptyRequiredParamsFor(
            $transactionType,
            $customRequiredParam,
            $parameters
        );

        if (!CommonUtils::isValidArray($customRequiredParamValues)) {
            return;
        }

        if (!CommonUtils::arrayContainsArrayItems($parameters)) {
            $this->checkIsParamSet(
                $transactionType,
                $parameters[$customRequiredParam],
                $customRequiredParamValues
            );

            return;
        }

        foreach ($parameters as $parameter) {
            $this->checkIsParamSet(
                $transactionType,
                $parameter[$customRequiredParam],
                $customRequiredParamValues
            );
        }
    }

    /**
     * @param string $transactionType
     * @param array $parameters
     * @param mixed $paramValues
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    private function checkIsParamSet($transactionType, $parameters, $paramValues)
    {
        if (!in_array($parameters, $paramValues)) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'Invalid value (%s) for required parameter: %s (Transaction type: %s)',
                    $parameters,
                    $paramValues,
                    $transactionType
                )
            );
        }
    }

    /**
     * Performs a check there is an empty required param for the passed transaction type
     *
     * @param string $transactionType
     * @param string $customRequiredParam
     * @param array $txnParameters
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function checkEmptyRequiredParamsFor(
        $transactionType,
        $customRequiredParam,
        $txnParameters = []
    ) {
        if (CommonUtils::isArrayKeyExists($customRequiredParam, $txnParameters) &&
            !empty($txnParameters[$customRequiredParam])
        ) {
            return;
        }

        foreach ($txnParameters as $parameter) {
            if (CommonUtils::isArrayKeyExists($customRequiredParam, $parameter) &&
                !empty($parameter[$customRequiredParam])
            ) {
                return;
            }
        }

        throw new \Genesis\Exceptions\ErrorParameter(
            sprintf(
                'Empty (null) required parameter: %s for transaction type %s',
                $customRequiredParam,
                $transactionType
            )
        );
    }

    /**
     * Add ISO 639-1 language code to the URL
     *
     * @param string $language iso code of the language
     *
     * @return $this
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setLanguage($language = \Genesis\API\Constants\i18n::EN)
    {
        $language = CommonUtils::filterLanguageCode($language);

        $this->allowedOptionsSetter(
            'language',
            i18n::getAll(),
            $language,
            'Invalid ISO-639-1 language code.'
        );

        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                'wpf',
                sprintf('%s/wpf', $this->language),
                false
            )
        );

        return $this;
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->setApiConfig('url', $this->buildRequestURL('wpf', 'wpf', false));
    }

    /**
     * Return the required parameters keys which values could evaluate as empty
     * Example value:
     * array(
     *     'class_property' => 'request_structure_key'
     * )
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return array(
            'amount' => CreditCard::REQUEST_KEY_AMOUNT
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'amount',
            'currency',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'return_cancel_url',
            'transaction_types'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldsConditional = [
            'remember_card' => [
                true => [
                    'customer_email'
                ]
            ],
            'consumer_id'   => [
                'customer_email'
            ]
        ];

        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
    }

    protected function checkRequirements()
    {
        $requiredFieldsValuesConditional = $this->getThreedsV2FieldValuesValidations() +
            $this->requiredRecurringInitialTypesFieldValuesConditional();

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject($requiredFieldsValuesConditional);

        parent::checkRequirements();

        $this->validateReminders();
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'wpf_payment' => [
                'transaction_id'            => $this->transaction_id,
                'amount'                    => $this->transform(
                    'amount',
                    [
                        $this->amount,
                        $this->currency
                    ]
                ),
                'currency'                  => $this->currency,
                'usage'                     => $this->usage,
                'description'               => $this->description,
                'consumer_id'               => $this->consumer_id,
                'customer_email'            => $this->customer_email,
                'customer_phone'            => $this->customer_phone,
                'notification_url'          => $this->notification_url,
                'return_success_url'        => $this->return_success_url,
                'return_failure_url'        => $this->return_failure_url,
                'return_cancel_url'         => $this->return_cancel_url,
                'return_pending_url'        => $this->getReturnPendingUrl(),
                'billing_address'           => $this->getBillingAddressParamsStructure(),
                'shipping_address'          => $this->getShippingAddressParamsStructure(),
                'remember_card'             => var_export($this->remember_card, true),
                'transaction_types'         => $this->transaction_types,
                'lifetime'                  => $this->lifetime,
                'risk_params'               => $this->getRiskParamsStructure(),
                'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure(),
                'pay_later'                 => var_export($this->pay_later, true),
                'reminder_language'         => $this->reminder_language,
                'reminders'                 => $this->getRemindersStructure(),
                'business_attributes'       => $this->getBusinessAttributesStructure(),
                'sca_preference'            => $this->sca_preference,
                'sca_params'                => [
                    'exemption' => $this->sca_exemption,
                ],
                'threeds_v2_params'         => $this->getThreedsV2ParamsStructure(),
                'web_payment_form_id'       => $this->web_payment_form_id,
                'recurring_type'            => $this->recurring_type,
                'recurring_category'        => $this->recurring_category
            ]
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }

    /**
     * Validates Reminders
     *
     * @throws ErrorParameter
     */
    protected function validateReminders()
    {
        $reminders = $this->getRemindersStructure();

        if (empty($reminders)) {
            return;
        }

        foreach ($reminders as $value) {
            if ($value['reminder']['after'] >= $this->lifetime) {
                throw new ErrorParameter(
                    sprintf(
                        'Reminder (%dmin) could not be greater than or equal to lifetime (%dmin).',
                        $value['reminder']['after'],
                        $this->lifetime
                    )
                );
            }
        }
    }
}

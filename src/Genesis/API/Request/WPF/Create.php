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
namespace Genesis\API\Request\WPF;

/**
 * Web-Payment-Form Request
 *
 * @package    Genesis
 * @subpackage Request
 *
 * @method $this setTransactionId($value) Set a Unique Transaction id
 * @method $this setUsage($value) Set the description of the transaction for later use
 * @method $this setAmount($value) Set the amount of transaction in minor currency unit
 * @method $this setCurrency($value) Set the currency code in ISO-4217
 * @method $this setDescription($value) Set a text describing the reason of the payment
 * @method $this setCustomerEmail($value) Set Email address of the Customer
 * @method $this setCustomerPhone($value) Set Phone number of the Customer

 * @method $this setNotificationUrl($value) Set the URL endpoint for Genesis Notifications
 * @method $this setReturnSuccessUrl($value) Set the URL where customer is sent to after successful payment
 * @method $this setReturnFailureUrl($value) Set the URL where customer is sent to after un-successful payment
 * @method $this setReturnCancelUrl($value) Set the  URL where the customer is sent to after they cancel the payment

 * @method $this setBillingFirstName($value) Set Customer's Billing Address: First name
 * @method $this setBillingLastName($value) Set Customer's Billing Address: First name
 * @method $this setBillingAddress1($value) Set Customer's Billing Address: Part 1
 * @method $this setBillingAddress2($value) Set Customer's Billing Address: Part 2
 * @method $this setBillingZipCode($value) Set Customer's Billing Address: ZIP
 * @method $this setBillingCity($value) Set Customer's Billing Address: City
 * @method $this setBillingState($value) Set Customer's Billing Address: State
 * @method $this setBillingCountry($value) Set Customer's Billing Address: Country

 * @method $this setShippingFirstName($value) Set Customer's Shipping Address: First name
 * @method $this setShippingLastName($value) Set Customer's Shipping Address: First name
 * @method $this setShippingAddress1($value) Set Customer's Shipping Address: Part 1
 * @method $this setShippingAddress2($value) Set Customer's Shipping Address: Part 2
 * @method $this setShippingZipCode($value) Set Customer's Shipping Address: ZIP
 * @method $this setShippingCity($value) Set Customer's Shipping Address: City
 * @method $this setShippingState($value) Set Customer's Shipping Address: State
 * @method $this setShippingCountry($value) Set Customer's Shipping Address: Country

 * @method $this setRiskSsn($value) Set the Social Security number or equivalent value for non US customers.
 * @method $this setRiskMacAddress($value) Set the Customer's MAC address
 * @method $this setRiskSessionId($value) Set the Customer's Session Id
 * @method $this setRiskUserId($value) Set the Customer's User Id
 * @method $this setRiskUserLevel($value) Set the Customer's User Level
 * @method $this setRiskEmail($value) Set the Customer's Email address
 * @method $this setRiskPhone($value) Set the Customer's Phone number
 * @method $this setRiskRemoteIp($value) Set the Customer's IP address
 * @method $this setRiskSerialNumber($value) Set the Customer's Serial Number
 *
 * @method $this setDynamicMerchantName($value) Dynamically override the charge descriptor
 * @method $this setDynamicMerchantCity($value) Dynamically override the merchant phone number
 */
class Create extends \Genesis\API\Request
{
    /**
     * unique transaction id defined by merchant
     *
     * @var string
     */
    protected $transaction_id;

    /**
     * Amount of transaction in minor currency unit
     *
     * @var int
     */
    protected $amount;

    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

    /**
     * Statement, as it appears in the customer’s bank statement
     *
     * @var string
     */
    protected $usage;

    /**
     * a text describing the reason of the payment
     *
     * e.g. "you’re buying concert tickets"
     *
     * @var string
     */
    protected $description;

    /**
     * Email address of the Customer
     *
     * @var string
     */
    protected $customer_email;

    /**
     * Phone number of the customer
     *
     * @var string
     */
    protected $customer_phone;

    /**
     * URL endpoint for Genesis Notifications
     *
     * @var string
     */
    protected $notification_url;

    /**
     * URL where customer is sent to after successful payment
     *
     * @var string
     */
    protected $return_success_url;

    /**
     * URL where customer is sent to after un-successful payment
     *
     * @var string
     */
    protected $return_failure_url;

    /**
     * URL where the customer is sent to after they cancel the payment
     *
     * @var string
     */
    protected $return_cancel_url;

    /**
     *Customer's Billing Address: First name
     *
     * @var string
     */
    protected $billing_first_name;

    /**
     * Customer's Billing Address: Last name
     *
     * @var string
     */
    protected $billing_last_name;

    /**
     * Customer's Billing Address: Part 1
     *
     * @var string
     */
    protected $billing_address1;

    /**
     * Customer's Billing Address: Part 2
     * @var string
     */
    protected $billing_address2;

    /**
     * Customer's Billing Address: ZIP
     *
     * @var string
     */
    protected $billing_zip_code;

    /**
     * Customer's Billing Address: City
     *
     * @var string
     */
    protected $billing_city;

    /**
     * Customer's Billing Address: State
     *
     * format: ISO-3166-2
     *
     * @var string
     */
    protected $billing_state;

    /**
     * Customer's Billing Address: Country
     *
     * format: ISO-3166
     *
     * @var string
     */
    protected $billing_country;

    /**
     * Customer's Shipping Address: First name
     *
     * @var string
     */
    protected $shipping_first_name;

    /**
     * Customer's Shipping Address: Last name
     *
     * @var string
     */
    protected $shipping_last_name;

    /**
     * Customer's Shipping Address: Part 1
     *
     * @var string
     */
    protected $shipping_address1;

    /**
     * Customer's Shipping Address: Part 2
     *
     * @var string
     */
    protected $shipping_address2;

    /**
     * Customer's Shipping Address: ZIP
     *
     * @var string
     */
    protected $shipping_zip_code;

    /**
     * Customer's Shipping Address: City
     *
     * @var string
     */
    protected $shipping_city;

    /**
     * Customer's Shipping Address: State
     *
     * format: ISO-3166-2
     *
     * @var string
     */
    protected $shipping_state;

    /**
     * Customer's Shipping Address
     *
     * format: ISO-3166
     *
     * @var string
     */
    protected $shipping_country;

    /**
     * The transaction types that the merchant is willing to accept payments for
     *
     * @var array
     */
    protected $transaction_types = array();

    /**
     * Social Security number or equivalent value for non US customers.
     *
     * @var string
     */
    protected $risk_ssn;

    /**
     * Customer's MAC address
     *
     * @var string
     */
    protected $risk_mac_address;

    /**
     * Customer's Session Id
     *
     * @var string
     */
    protected $risk_session_id;

    /**
     * Customer's User Id
     *
     * @var string
     */
    protected $risk_user_id;

    /**
     * Customer's User Level
     *
     * @var string
     */
    protected $risk_user_level;

    /**
     * Customer's Email address
     *
     * @note Set here if different from
     *       shipping / billing
     *
     * @var string
     */
    protected $risk_email;

    /**
     * Customer's Phone number
     *
     * @note Set here if different from
     *       shipping / billing
     *
     * @var string
     */
    protected $risk_phone;

    /**
     * Customer's IP address
     *
     * @note Set here if different from remote_ip
     *
     * @var string
     */
    protected $risk_remote_ip;

    /**
     * Customer's Serial Number
     *
     * @var string
     */
    protected $risk_serial_number;

    /**
     * Allows to dynamically override the charge descriptor
     *
     * @var string
     */
    protected $dynamic_merchant_name;

    /**
     * Allows to dynamically override the mer- chant phone number
     *
     * @var string
     */
    protected $dynamic_merchant_city;

    /**
     * Add transaction type to the list of available types
     *
     * @param string $name
     *
     * @param array  $parameters
     *
     * @return $this
     */
    public function addTransactionType($name, $parameters = array())
    {
        $this->verifyTransactionType($name, $parameters);

        $structure = array(
            'transaction_type' => array(
                '@attributes' => array(
                    'name' => $name
                ),
                $parameters
            )
        );

        array_push($this->transaction_types, $structure);

        return $this;
    }

    /**
     * Verify that transaction type parameters are populated correctly
     *
     * @param string $transactionType
     * @param array $parameters
     * @throws \Genesis\Exceptions\ErrorParameter
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function verifyTransactionType($transactionType, $parameters = array())
    {
        if (!\Genesis\API\Constants\Transaction\Types::isValidTransactionType($transactionType)) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'Transaction type (%s) is not valid',
                    $transactionType
                )
            );
        }

        $txnCustomRequiredParams = \Genesis\API\Constants\Transaction\Types::getCustomRequiredParameters(
            $transactionType
        );

        if (\Genesis\Utils\Common::isValidArray($txnCustomRequiredParams)) {
            foreach ($txnCustomRequiredParams as $customRequiredParam => $customRequiredParamValues) {
                if (!array_key_exists($customRequiredParam, $parameters)) {
                    foreach ($parameters as $parameter) {
                        if (!\Genesis\Utils\Common::isValidArray($parameter) ||
                            !array_key_exists($customRequiredParam, $parameter)) {
                            throw new \Genesis\Exceptions\ErrorParameter(
                                sprintf(
                                    'Empty (null) required parameter: %s for transaction type %s',
                                    $customRequiredParam,
                                    $transactionType
                                )
                            );
                        }
                    }
                }

                if (\Genesis\Utils\Common::isValidArray($customRequiredParamValues)) {
                    if (!\Genesis\Utils\Common::arrayContainsArrayItems($parameters)) {
                        if (!in_array($parameters[$customRequiredParam], $customRequiredParamValues)) {
                            sprintf(
                                'Invalid value (%s) for required parameter: %s (Transaction type: %s)',
                                $parameters[$customRequiredParam],
                                $customRequiredParam,
                                $transactionType
                            );
                        }

                        continue;
                    }

                    foreach ($parameters as $parameter) {
                        if (!in_array($parameter[$customRequiredParam], $customRequiredParamValues)) {
                            throw new \Genesis\Exceptions\ErrorParameter(
                                sprintf(
                                    'Invalid value (%s) for required parameter: %s (Transaction type: %s)',
                                    $parameter[$customRequiredParam],
                                    $customRequiredParam,
                                    $transactionType
                                )
                            );
                        }
                    }
                }
            }
        }
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
        // Strip the input down to two letters
        $language = substr(strtolower($language), 0, 2);

        if (!\Genesis\API\Constants\i18n::isValidLanguageCode($language)) {
            throw new \Genesis\Exceptions\InvalidArgument(
                'The provided argument is not a valid ISO-639-1 language code!'
            );
        }

        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                'wpf',
                sprintf('%s/wpf', $language),
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
        $this->config = \Genesis\Utils\Common::createArrayObject(
            array(
                'protocol' => 'https',
                'port'     => 443,
                'type'     => 'POST',
                'format'   => 'xml'
            )
        );

        $this->setApiConfig('url', $this->buildRequestURL('wpf', 'wpf', false));
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = array(
            'transaction_id',
            'amount',
            'currency',
            'description',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'return_cancel_url',
            'transaction_types'
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = array(
            'wpf_payment' => array(
                'transaction_id'     => $this->transaction_id,
                'amount'             => $this->transform(
                    'amount',
                    array(
                        $this->amount,
                        $this->currency,
                    )
                ),
                'currency'           => $this->currency,
                'usage'              => $this->usage,
                'description'        => $this->description,
                'customer_email'     => $this->customer_email,
                'customer_phone'     => $this->customer_phone,
                'notification_url'   => $this->notification_url,
                'return_success_url' => $this->return_success_url,
                'return_failure_url' => $this->return_failure_url,
                'return_cancel_url'  => $this->return_cancel_url,
                'billing_address'    => array(
                    'first_name' => $this->billing_first_name,
                    'last_name'  => $this->billing_last_name,
                    'address1'   => $this->billing_address1,
                    'address2'   => $this->billing_address2,
                    'zip_code'   => $this->billing_zip_code,
                    'city'       => $this->billing_city,
                    'state'      => $this->billing_state,
                    'country'    => $this->billing_country
                ),
                'shipping_address'   => array(
                    'first_name' => $this->shipping_first_name,
                    'last_name'  => $this->shipping_last_name,
                    'address1'   => $this->shipping_address1,
                    'address2'   => $this->shipping_address2,
                    'zip_code'   => $this->shipping_zip_code,
                    'city'       => $this->shipping_city,
                    'state'      => $this->shipping_state,
                    'country'    => $this->shipping_country
                ),
                'transaction_types'  => $this->transaction_types,
                'risk_params'        => array(
                    'ssn'           => $this->risk_ssn,
                    'mac_address'   => $this->risk_mac_address,
                    'session_id'    => $this->risk_session_id,
                    'user_id'       => $this->risk_user_id,
                    'user_level'    => $this->risk_user_level,
                    'email'         => $this->risk_email,
                    'phone'         => $this->risk_phone,
                    'remote_ip'     => $this->risk_remote_ip,
                    'serial_number' => $this->risk_serial_number
                ),
                'dynamic_descriptor_params' => array(
                    'merchant_name' => $this->dynamic_merchant_name,
                    'merchant_city' => $this->dynamic_merchant_city
                )
            )
        );

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

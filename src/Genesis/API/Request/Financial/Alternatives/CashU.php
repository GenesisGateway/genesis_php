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
namespace Genesis\API\Request\Financial\Alternatives;

/**
 * Class CashU
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives
 */
class CashU extends \Genesis\API\Request
{
    /**
     * Unique transaction id defined by mer-chant
     *
     * @var string
     */
    protected $transaction_id;

    /**
     * Description of the transaction for later use
     *
     * @var string
     */
    protected $usage;

    /**
     * IPv4 address of customer
     *
     * @var string
     */
    protected $remote_ip;

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
                'format'   => 'xml',
            )
        );

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'process', \Genesis\Config::getToken()));
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
            'remote_ip',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'customer_email',
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
            'payment_transaction' => array(
                'transaction_type'   => \Genesis\API\Constants\Transaction\Types::CASHU,
                'transaction_id'     => $this->transaction_id,
                'usage'              => $this->usage,
                'remote_ip'          => $this->remote_ip,
                'return_success_url' => $this->return_success_url,
                'return_failure_url' => $this->return_failure_url,
                'amount'             => $this->transform(
                    'amount',
                    array(
                        $this->amount,
                        $this->currency,
                    )
                ),
                'currency'           => $this->currency,
                'customer_email'     => $this->customer_email,
                'customer_phone'     => $this->customer_phone,
                'billing_address'    => array(
                    'first_name' => $this->billing_first_name,
                    'last_name'  => $this->billing_last_name,
                    'address1'   => $this->billing_address1,
                    'address2'   => $this->billing_address2,
                    'zip_code'   => $this->billing_zip_code,
                    'city'       => $this->billing_city,
                    'state'      => $this->billing_state,
                    'country'    => $this->billing_country,
                ),
                'shipping_address'   => array(
                    'first_name' => $this->shipping_first_name,
                    'last_name'  => $this->shipping_last_name,
                    'address1'   => $this->shipping_address1,
                    'address2'   => $this->shipping_address2,
                    'zip_code'   => $this->shipping_zip_code,
                    'city'       => $this->shipping_city,
                    'state'      => $this->shipping_state,
                    'country'    => $this->shipping_country,
                ),
                'risk_params'        => array(
                    'ssn'           => $this->risk_ssn,
                    'mac_address'   => $this->risk_mac_address,
                    'session_id'    => $this->risk_session_id,
                    'user_id'       => $this->risk_user_id,
                    'user_level'    => $this->risk_user_level,
                    'email'         => $this->risk_email,
                    'phone'         => $this->risk_phone,
                    'remote_ip'     => $this->risk_remote_ip,
                    'serial_number' => $this->risk_serial_number,
                ),
            )
        );

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

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
namespace Genesis\API\Request\Financial\Cards;

/**
 * Payout Request
 *
 * @package    Genesis
 * @subpackage Request
 */
class Payout extends \Genesis\API\Request
{
    /**
     * Unique transaction id defined by merchant
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
     * Amount of transaction in minor currency unit
     *
     * @var int|float|double
     */
    protected $amount;

    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

    /**
     * Full name of customer as printed on credit card (first name and last name at least)
     *
     * @var string
     */
    protected $card_holder;

    /**
     * Complete CC number of customer
     *
     * @var int
     */
    protected $card_number;

    /**
     * CVV of CC, requirement is based on terminal configuration
     *
     * @var int
     */
    protected $cvv;

    /**
     * Expiration month as printed on credit card
     *
     * @var string (mm)
     */
    protected $expiration_month;

    /**
     * Expiration year as printed on credit card
     *
     * @var string (yyyy)
     */
    protected $expiration_year;

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
            'amount',
            'currency',
            'card_holder',
            'card_number',
            'expiration_month',
            'expiration_year',
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
                'transaction_type' => \Genesis\API\Constants\Transaction\Types::PAYOUT,
                'transaction_id'   => $this->transaction_id,
                'usage'            => $this->usage,
                'amount'           => $this->transform(
                    'amount',
                    array(
                        $this->amount,
                        $this->currency,
                    )
                ),
                'currency'         => $this->currency,
                'remote_ip'        => $this->remote_ip,
                'card_holder'      => $this->card_holder,
                'card_number'      => $this->card_number,
                'cvv'              => $this->cvv,
                'expiration_month' => $this->expiration_month,
                'expiration_year'  => $this->expiration_year,
                'customer_email'   => $this->customer_email,
                'customer_phone'   => $this->customer_phone,
                'billing_address'  => array(
                    'first_name' => $this->billing_first_name,
                    'last_name'  => $this->billing_last_name,
                    'address1'   => $this->billing_address1,
                    'address2'   => $this->billing_address2,
                    'zip_code'   => $this->billing_zip_code,
                    'city'       => $this->billing_city,
                    'state'      => $this->billing_state,
                    'country'    => $this->billing_country,
                ),
                'shipping_address' => array(
                    'first_name' => $this->shipping_first_name,
                    'last_name'  => $this->shipping_last_name,
                    'address1'   => $this->shipping_address1,
                    'address2'   => $this->shipping_address2,
                    'zip_code'   => $this->shipping_zip_code,
                    'city'       => $this->shipping_city,
                    'state'      => $this->shipping_state,
                    'country'    => $this->shipping_country,
                )
            )
        );

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

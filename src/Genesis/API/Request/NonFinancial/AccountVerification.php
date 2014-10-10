<?php
/**
 * Account Verification Request
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\NonFinancial;

use \Genesis\API\Request as Request;
use \Genesis\Utils\Common as Common;

class AccountVerification extends Request
{
    protected $transaction_id;

    protected $usage;
    protected $moto;

    protected $remote_ip;
    protected $card_holder;
    protected $card_number;
    protected $cvv;
    protected $expiration_month;
    protected $expiration_year;
    protected $customer_email;
    protected $customer_phone;

    protected $billing_address;
    protected $billing_first_name;
    protected $billing_last_name;
    protected $billing_address1;
    protected $billing_address2;
    protected $billing_zip_code;
    protected $billing_city;
    protected $billing_state;
    protected $billing_country;

    protected $shipping_address;
    protected $shipping_first_name;
    protected $shipping_last_name;
    protected $shipping_address1;
    protected $shipping_address2;
    protected $shipping_zip_code;
    protected $shipping_city;
    protected $shipping_state;
    protected $shipping_country;

    protected $risk_ssn;
    protected $risk_mac_address;
    protected $risk_session_id;
    protected $risk_user_id;
    protected $risk_user_level;
    protected $risk_email;
    protected $risk_phone;
    protected $risk_remote_ip;
    protected $risk_serial_number;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'process', true));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'payment_transaction' => array (
                'transaction_type'  => 'account_verification',
                'transaction_id'    => $this->transaction_id,
                'usage'             => $this->usage,
                'moto'              => $this->moto,
                'remote_ip'         => $this->remote_ip,
                'card_holder'       => $this->card_holder,
                'card_number'       => $this->card_number,
                'cvv'               => $this->cvv,
                'expiration_month'  => $this->expiration_month,
                'expiration_year'   => $this->expiration_year,
                'customer_email'    => $this->customer_email,
                'customer_phone'    => $this->customer_phone,
                'billing_address'   => array(
                    'first_name'        => $this->billing_first_name,
                    'last_name'         => $this->billing_last_name,
                    'address1'          => $this->billing_address1,
                    'address2'          => $this->billing_address2,
                    'zip_code'          => $this->billing_zip_code,
                    'city'              => $this->billing_city,
                    'state'             => $this->billing_state,
                    'country'           => $this->billing_country,
                ),
                'shipping_address'  => array(
                    'first_name'        => $this->shipping_first_name,
                    'last_name'         => $this->shipping_last_name,
                    'address1'          => $this->shipping_address1,
                    'address2'          => $this->shipping_address2,
                    'zip_code'          => $this->shipping_zip_code,
                    'city'              => $this->shipping_city,
                    'state'             => $this->shipping_state,
                    'country'           => $this->shipping_country,
                ),
                'risk_params'       => array(
                    'ssn'               => $this->risk_ssn,
                    'mac_address'       => $this->risk_mac_address,
                    'session_id'        => $this->risk_session_id,
                    'user_id'           => $this->risk_user_id,
                    'user_level'        => $this->risk_user_level,
                    'email'             => $this->risk_email,
                    'phone'             => $this->risk_phone,
                    'remote_ip'         => $this->risk_remote_ip,
                    'serial_number'     => $this->risk_serial_number,
                )
            )
        );

        $this->treeStructure = Common::createArrayObject($treeStructure);
    }

    private function initConfiguration()
    {
        $config = array (
            'url'       => '',
            'port'      => 443,
            'type'      => 'POST',
            'format'    => 'xml',
            'protocol'  => 'https',
        );

        $this->config = Common::createArrayObject($config);
    }

    private function setRequiredFields()
    {
        $requiredFields = array (
            'transaction_id',
            'remote_ip',
            'card_holder',
            'card_number',
            'cvv',
            'expiration_month',
            'expiration_year',
            'customer_email',
            'billing_first_name',
            'billing_last_name',
            'billing_address1',
            'billing_zip_code',
            'billing_city',
            'billing_country'
        );

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }
}

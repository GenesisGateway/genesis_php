<?php
/**
 * Web-Payment-Form Request
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\WPF;

use \Genesis\Utils\Common as Common;
use \Genesis\API\Request as Request;

class Create extends Request
{
    protected $transaction_id;

    protected $amount;
    protected $currency;
    protected $usage;
    protected $description;

    protected $customer_email;
    protected $customer_phone;

    protected $notification_url;
    protected $return_success_url;
    protected $return_failure_url;
    protected $return_cancel_url;

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

    protected $transaction_type;

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

        $this->setApiConfig('url', $this->buildRequestURL('wpf', 'wpf', false));
    }

	public function setLanguage($language = '')
	{
		$path = sprintf('%s/wpf', substr($language, 0, 2));

		$this->setApiConfig('url', $this->buildRequestURL('wpf', $path, false));
	}

    protected function populateStructure()
    {
        $treeStructure = array (
            'wpf_payment' => array (
                'transaction_id'        => $this->transaction_id,
                'amount'                => $this->amount,
                'currency'              => $this->currency,
                'usage'                 => $this->usage,
                'description'           => $this->description,
                'customer_email'        => $this->customer_email,
                'customer_phone'        => $this->customer_phone,
                'notification_url'      => $this->notification_url,
                'return_success_url'    => $this->return_success_url,
                'return_failure_url'    => $this->return_failure_url,
                'return_cancel_url'     => $this->return_cancel_url,
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
                'transaction_types' => $this->transaction_type,
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
                ),
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
            'amount',
            'currency',
            'usage',
            'description',
            'customer_email',
            'customer_phone',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'return_cancel_url',
            'billing_first_name',
            'billing_last_name',
            'billing_address1',
            'billing_zip_code',
            'billing_city',
            'billing_country',
            'transaction_type',
        );

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }
}

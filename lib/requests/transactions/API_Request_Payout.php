<?php

namespace Genesis;

class API_Request_Payout extends Genesis_API_Request_Base
{
    protected $transaction_id;

    protected $usage;

    protected $remote_ip;
    protected $amount;
    protected $currency;
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

    public function __construct()
    {
        $config = array (
            'url'           => 'process',
            'SSL'      => true,
            'requestType'   => 'POST',
        );

        $this->createArrayObject('config', $config);

        $requiredFields = array (
            'transaction_type',
            'transaction_id',
            'remote_ip',
            'amount',
            'currency',
            'card_holder',
            'card_number',
            'cvv',
            'expiration_month',
            'expiration_year',
            'customer_email',
            'first_name',
            'last_name',
            'address1',
            'zip_code',
            'city',
            'country'
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }

    protected function mapToTreeStructure()
    {
        $treeStructure = array (
            'payment_transaction' => array (
                'transaction_type'  => 'credit',
                'transaction_id'    => $this->transaction_id,
                'usage'             => $this->usage,
                'amount'            => $this->amount,
                'currency'          => $this->currency,
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
                    'zip_code'          => $this->billing_zip_code,
                    'city'              => $this->billing_city,
                    'state'             => $this->billing_state,
                    'country'           => $this->billing_country,
                ),
                'shipping_address'  => array(
                    'first_name'        => $this->shipping_first_name,
                    'last_name'         => $this->shipping_last_name,
                    'address1'          => $this->shipping_address1,
                    'zip_code'          => $this->shipping_zip_code,
                    'city'              => $this->shipping_city,
                    'state'             => $this->shipping_state,
                    'country'           => $this->shipping_country,
                )
            )
        );

        $this->createArrayObject('treeStructure', $treeStructure);
    }
}
<?php

namespace Genesis;

class API_Request_Sale_3D extends Genesis_API_Request_Base
{
    public $transaction_type;
    public $transaction_id;

    public $usage;
    public $gaming;
    public $moto;

    public $remote_ip;
    public $notification_url;
    public $return_success_url;
    public $return_failure_url;

    public $amount;
    public $currency;
    public $card_holder;
    public $card_number;
    public $cvv;
    public $expiration_month;
    public $expiration_year;
    public $customer_email;
    public $customer_phone;

    public $billing_address;
    public $billing_first_name;
    public $billing_last_name;
    public $billing_address1;
    public $billing_address2;
    public $billing_zip_code;
    public $billing_city;
    public $billing_state;
    public $billing_country;

    public $shipping_address;
    public $shipping_first_name;
    public $shipping_last_name;
    public $shipping_address1;
    public $shipping_address2;
    public $shipping_zip_code;
    public $shipping_city;
    public $shipping_state;
    public $shipping_country;

    public $mpi_params;
    public $mpi_cavv;
    public $mpi_eci;
    public $mpi_xid;

    public $dynamic_descriptor_params;
    public $dynamic_merchant_name;
    public $dynamic_merchant_city;
}
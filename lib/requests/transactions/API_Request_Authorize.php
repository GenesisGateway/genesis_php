<?php

namespace Genesis;

class API_Request_Authorize extends Genesis_API_Request_Base
{
    public $transaction_type;
    public $transaction_id;

    public $usage;
    public $gaming;
    public $moto;

    public $remote_ip;
    public $amount;
    public $currency;
    public $card_holder;
    public $expiration_month;
    public $expiration_year;
    public $customer_email;
    public $customer_phone;
    public $card_number;
    public $cvv;

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
}
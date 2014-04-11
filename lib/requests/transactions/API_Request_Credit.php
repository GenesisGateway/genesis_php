<?php

namespace Genesis;

class API_Request_Credit extends Genesis_API_Request_Base
{
    public $transaction_id;

    public $usage;

    public $remote_ip;
    public $reference_id;
    public $amount;
    public $currency;
}
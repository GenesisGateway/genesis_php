<?php

namespace Genesis;

class API_Request_Credit extends Genesis_API_Request_Base
{
    protected $transaction_id;

    protected $usage;

    protected $remote_ip;
    protected $reference_id;
    protected $amount;
    protected $currency;

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
            'reference_id',
            'amount',
            'currency'
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }

    protected function mapToTreeStructure()
    {
        $treeStructure = array (
            'payment_transaction' => array (
                'transaction_type'  => 'refund',
                'transaction_id'    => $this->transaction_id,
                'usage'             => $this->usage,
                'remote_ip'         => $this->remote_ip,
                'reference_id'      => $this->reference_id,
                'amount'            => $this->amount,
                'currency'          => $this->currency
            )
        );

        $this->createArrayObject('treeStructure', $treeStructure);
    }
}
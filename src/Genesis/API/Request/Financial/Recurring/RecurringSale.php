<?php

namespace Genesis\API\Request\Financial\Recurring;

use \Genesis\API\Base as RequestBase;

class RecurringSale extends RequestBase
{
    protected $transaction_id;

    protected $usage;

    protected $remote_ip;
    protected $reference_id;
    protected $amount;
    protected $currency;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setRequestURL('gateway', 'process', true);
    }

    protected function mapToTreeStructure()
    {
        $treeStructure = array (
            'payment_transaction' => array (
                'transaction_type'  => 'recurring_sale',
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

    private function initConfiguration()
    {
        $config = array (
            'url'       => '',
            'port'      => null,
            'type'      => 'POST',
            'protocol'  => 'https',
            'transport' => 'tls',
        );

        $this->createArrayObject('config', $config);
    }

    private function setRequiredFields()
    {
        $requiredFields = array (
            'transaction_id',
            'remote_ip',
            'reference_id',
            'amount',
            'currency'
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }
}

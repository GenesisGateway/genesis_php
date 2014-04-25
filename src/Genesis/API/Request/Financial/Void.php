<?php

namespace Genesis\API\Request\Financial;

use \Genesis\API\Base as RequestBase;

class Void extends RequestBase
{
    protected $transaction_id;

    protected $usage;

    protected $remote_ip;
    protected $reference_id;

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
                'transaction_type'  => 'void',
                'transaction_id'    => $this->transaction_id,
                'usage'             => $this->usage,
                'remote_ip'         => $this->remote_ip,
                'reference_id'      => $this->reference_id,
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
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }
}

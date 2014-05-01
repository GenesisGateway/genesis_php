<?php

namespace Genesis\API\Request\Reconcile;

use \Genesis\API\Request as RequestBase;

class Transaction extends RequestBase
{
    protected $unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setRequestURL('gateway', 'reconcile', true);
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'reconcile' => array (
                'unique_id'  => $this->unique_id,
            )
        );

        $this->createArrayObject('treeStructure', $treeStructure);
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

        $this->createArrayObject('config', $config);
    }

    private function setRequiredFields()
    {
        $requiredFields = array (
            'unique_id',
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }
}

<?php

namespace Genesis\API\Request\WPF;

use \Genesis\API\Request as RequestBase;

class Reconcile extends RequestBase
{
    protected $unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setRequestURL('wpf', 'wpf/reconcile', false);
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'wpf_reconcile' => array (
                'unique_id' => $this->unique_id,
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

<?php

namespace Genesis\API\Request\WPF;

use \Genesis\API\Base as RequestBase;

class Reconcile extends RequestBase
{
    protected $unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setRequestURL('wpf', 'wpf/reconcile', false);
    }

    protected function mapToTreeStructure()
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
            'unique_id',
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }
}

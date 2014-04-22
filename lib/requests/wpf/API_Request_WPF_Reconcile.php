<?php

namespace Genesis;


class API_Request_WPF_Reconcile extends Genesis_API_Request_Base
{
    protected $unique_id;

    public function __construct()
    {
        $config = array (
            'url'           => $this->getRequestURL('wpf', 'wpf/reconcile'),
            'SSL'      => true,
            'requestType'   => 'POST',
        );

        $this->createArrayObject('config', $config);

        $requiredFields = array (
            'unique_id',
        );

        $this->createArrayObject('requiredFields', $requiredFields);
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
}
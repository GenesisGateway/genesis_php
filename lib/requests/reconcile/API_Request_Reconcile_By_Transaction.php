<?php

namespace Genesis;

class API_Request_Reconcile_By_Transaction extends Genesis_API_Request_Base
{
    protected $unique_id;

    public function __construct()
    {
        $config = array (
            'url'           => 'reconcile',
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
            'reconcile' => array (
                'unique_id'  => $this->unique_id,
            )
        );

        $this->createArrayObject('treeStructure', $treeStructure);
    }
}
<?php

namespace Genesis;

class API_Request_Reconcile_By_Date_Range extends Genesis_API_Request_Base
{
    protected $start_date;
    protected $end_date;

    protected $page;

    public function __construct()
    {
        $config = array (
            'url'           => 'reconcile/by_date',
            'SSL'      => true,
            'requestType'   => 'POST',
        );

        $this->createArrayObject('config', $config);

        $requiredFields = array (
            'start_date',
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }

    protected function mapToTreeStructure()
    {
        $structure = array (
            'reconcile' => array (
                'start_date'  => $this->start_date,
                'end_date'    => $this->end_date,
                'page'        => $this->page,
            )
        );

        $this->createArrayObject('treeStructure', $structure);
    }
}
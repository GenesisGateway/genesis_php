<?php

namespace Genesis\API\Request\Reconcile;

use \Genesis\API\Request as RequestBase;

class DateRange extends RequestBase
{
    protected $start_date;
    protected $end_date;

    protected $page;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setRequestURL('gateway', 'reconcile/by_date', true);
    }

    protected function populateStructure()
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
            'start_date',
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }
}

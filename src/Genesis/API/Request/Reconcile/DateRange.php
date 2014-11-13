<?php
/**
 * Reconcile request by Date Range
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\Reconcile;

use \Genesis\API\Request as Request;
use \Genesis\Utils\Common as Common;

class DateRange extends Request
{
    protected $start_date;
    protected $end_date;

    protected $page;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'reconcile/by_date', true));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'reconcile' => array (
                'start_date'  => $this->start_date,
                'end_date'    => $this->end_date,
                'page'        => $this->page,
            )
        );

        $this->treeStructure = Common::createArrayObject($treeStructure);
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

        $this->config = Common::createArrayObject($config);
    }

    private function setRequiredFields()
    {
        $requiredFields = array (
            'start_date',
        );

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }
}

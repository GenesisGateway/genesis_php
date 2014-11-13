<?php
/**
 * Web-Payment-Form Reconcile
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\WPF;

use \Genesis\Utils\Common as Common;
use \Genesis\API\Request as Request;

class Reconcile extends Request
{
    protected $unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('wpf', 'wpf/reconcile', false));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'wpf_reconcile' => array (
                'unique_id' => $this->unique_id,
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
            'unique_id',
        );

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }
}

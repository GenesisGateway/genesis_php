<?php
/**
 * Reconcile request by transaction id
 *
 * @package Genesis
 * @subpackage Request
 */
namespace Genesis\API\Request\Reconcile;

class Transaction extends \Genesis\API\Request
{
    protected $unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'reconcile', true));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'reconcile' => array (
                'unique_id'  => $this->unique_id,
            )
        );

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
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

        $this->config = \Genesis\Utils\Common::createArrayObject($config);
    }

    private function setRequiredFields()
    {
        $requiredFields = array (
            'unique_id',
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }
}

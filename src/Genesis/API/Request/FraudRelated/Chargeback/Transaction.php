<?php
/**
 * Chargeback request by ARN/Unique Transaction Id
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\FraudRelated\Chargeback;


use \Genesis\API\Request as RequestBase;
use Genesis\Utils\Common;

class Transaction extends RequestBase
{
    protected $arn;
    protected $original_transaction_unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'chargebacks', false));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'chargeback_request' => array (
                'arn'                               => $this->arn,
                'original_transaction_unique_id'    => $this->original_transaction_unique_id,
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
        $requiredFieldsOR = array (
            'arn',
            'original_transaction_unique_id'
        );

        $this->requiredFieldsOR = Common::createArrayObject($requiredFieldsOR);
    }
}


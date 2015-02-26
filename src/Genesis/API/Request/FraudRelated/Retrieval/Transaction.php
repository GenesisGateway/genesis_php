<?php
/**
 * Retrieval request by ARN/Unique Transaction Id
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\FraudRelated\Retrieval;

class Transaction extends \Genesis\API\Request
{
    protected $arn;
    protected $original_transaction_unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'retrieval_requests', false));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'retrieval_request_request' => array (
                'arn'                               => $this->arn,
                'original_transaction_unique_id'    => $this->original_transaction_unique_id,
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
        $requiredFieldsOR = array (
            'arn',
            'original_transaction_unique_id'
        );

        $this->requiredFieldsOR = \Genesis\Utils\Common::createArrayObject($requiredFieldsOR);
    }
}


<?php
/**
 * Refund request
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\Financial;

use \Genesis\API\Request as Request;
use \Genesis\Utils\Common as Common;

class Refund extends Request
{
    protected $transaction_id;

    protected $usage;

    protected $remote_ip;
    protected $reference_id;
    protected $amount;
    protected $currency;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'process', true));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'payment_transaction' => array (
                'transaction_type'  => 'refund',
                'transaction_id'    => $this->transaction_id,
                'usage'             => $this->usage,
                'remote_ip'         => $this->remote_ip,
                'reference_id'      => $this->reference_id,
                'amount'            => $this->amount,
                'currency'          => $this->currency
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
            'transaction_id',
            'remote_ip',
            'reference_id',
            'amount',
            'currency'
        );

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }
}

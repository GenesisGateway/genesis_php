<?php
/**
 * Blacklist Request
 *
 * @package Genesis
 * @subpackage Request
 */

namespace Genesis\API\Request\FraudRelated;

use \Genesis\API\Request as RequestBase;
use Genesis\Utils\Common;

class Blacklist extends RequestBase
{
    protected $card_number;
    protected $terminal_token;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'blacklists', false));
    }

    protected function populateStructure()
    {
        $treeStructure = array (
            'blacklist_request' => array (
                'card_number'       => $this->card_number,
                'terminal_token'    => $this->terminal_token,
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
            'card_number',
        );

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }
}

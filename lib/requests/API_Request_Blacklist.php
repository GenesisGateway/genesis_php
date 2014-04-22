<?php

namespace Genesis;

class API_Request_Blacklist extends Genesis_API_Request_Base
{
    protected $card_number;
    protected $terminal_token;

    public function __construct()
    {
        $config = array (
            'URL'   => $this->getRequestURL('gateway', 'process'),
            'SSL'   => true,
            'TYPE'  => 'POST',
        );

        $this->createArrayObject('config', $config);

        $requiredFields = array (
            'card_number',
            'terminal_token',
        );

        $this->createArrayObject('requiredFields', $requiredFields);
    }

    protected function mapToTreeStructure()
    {
        $treeStructure = array (
            'blacklist_request' => array (
                'card_number'       => $this->card_number,
                'terminal_token'    => $this->terminal_token,
            )
        );

        $this->createArrayObject('treeStructure', $treeStructure);
    }
}
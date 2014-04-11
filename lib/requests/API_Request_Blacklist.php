<?php

namespace Genesis;

class API_Request_Blacklist extends Genesis_API_Request_Base
{
    public function __construct()
    {
        $this->requestConfig = array (
            'url'           => 'process',
            'isSecure'      => true,
            'requestType'   => 'POST',
        );

        $this->fieldStructure = array (
            'blacklist_request' => array (
                'card_number'       => null,
                'terminal_token'    => null,
            )
        );

        $this->fieldMandatory = array (
            'card_number',
            'terminal_token'
        );
    }
}
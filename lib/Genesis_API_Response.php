<?php

namespace Genesis;


class Genesis_API_Response extends Genesis_Base
{
    private $response;
    private $responseObject;

    public function __construct($response)
    {
        $this->response = $response;
        $this->responseObject = simplexml_load_string($response);
    }
}
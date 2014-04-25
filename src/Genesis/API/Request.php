<?php

namespace Genesis\API;

use \Genesis\Network as Network;
use \Genesis\Base as GenesisBase;
use \Genesis\Utils\Builders as Builders;

class Request
{
    /**
     * Placeholder for the HTTP_Request instance
     * @var \Genesis\Network\Request
     */
    #private $httpRequest;
    /**
     * Placeholder for the API_Request instance
     * @var \Genesis\API\Base
     */
    #private $requestContext;
    /**
     * Placeholder for the generated XML Document
     * @var String
     */
    #private $xmlDocument;



    /**
     * Redirect get/set requests from this instance to the Request Context
     *
     * @param $method
     * @param $args
     * @return mixed
     */

    /*
    public function __call($method, $args)
    {
        $requestedKey = strtolower(GenesisBase::uppercaseToUnderscore(substr($method, 3)));

        switch (substr($method, 0, 3)) {
            case 'add' :
                if (is_array($this->requestContext->$requestedKey)) {
                    $arr = $this->requestContext->$requestedKey;
                }
                else {
                    $arr = array();
                }

                array_push($arr, array($requestedKey => trim(reset($args))));
                $this->requestContext->$requestedKey = $arr;
                break;
            case 'get' :
                return $this->requestContext->config->offsetGet($requestedKey);
                break;
            case 'set' :
                $this->requestContext->$requestedKey = trim(reset($args));
                break;
        }

        return null;
    }
    */



}

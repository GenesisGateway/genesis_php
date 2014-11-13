<?php
/**
 * Response handler - handles responses from Genesis Gateway
 *
 * @package Genesis
 * @subpackage API
 */

namespace Genesis\API;

use Genesis\Exceptions;
use Genesis\Network\Request as Network;

class Response
{
    /**
     * Store parsed, response object
     *
     * @var \stdClass
     */
    public $responseObj;

    /**
     * Store the response raw data
     *
     * @var String
     */
    public $responseRaw;

    /**
     * Network Context Handle
     *
     * @var Network
     */
    private $networkContext;

    public function __construct(Network $networkContext)
    {
        $this->networkContext = $networkContext;

        if ( strlen($this->networkContext->getResponseBody()) > 0 ) {
            $this->parseResponse($this->networkContext->getResponseBody());
        }
    }

    /**
     * Check whether the request was successful
     *
     * Note: You should consult with the documentation
     * which transaction responses have status available.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $status = false;

        if (isset($this->responseObj->status) && in_array($this->responseObj->status, array('approved', 'pending_async'))) {
            $status = true;
        }

        return $status;
    }

    /**
     * Try to fetch a description of the received Error Code
     *
     * @return bool|string
     */
    public function getErrorDescription()
    {
        if (isset($this->responseObj->code)) {
            return Errors::getErrorDescription($this->responseObj->code);
        }
        else {
            return Errors::getIssuerResponseCode($this->responseObj->response_code);
        }
    }

    /**
     * Get the raw Genesis output
     *
     * @return String
     */
    public function getResponseRaw()
    {
        return $this->responseRaw;
    }

    /**
     * Get the parsed response
     *
     * @return \stdClass
     */
    public function getResponseObject()
    {
        return $this->responseObj;
    }

    /**
     * Parse Genesis response to SimpleXMLElement
     *
     * @param $response \SimpleXMLElement
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function parseResponse($response)
    {
        if (empty($response)) {
            throw new Exceptions\InvalidArgument();
        }

        $this->responseRaw = $response;
        $this->responseObj = simplexml_load_string($response);
    }
}
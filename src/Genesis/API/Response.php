<?php

namespace Genesis\API;

use Genesis\Exceptions;

class Response
{
    private $responseObj;

    /**
     * Check whether the request was successful
     *
     * @return bool
     */
    public function isSuccess()
    {
        $status = false;

        if (isset($this->responseObj->status) && $this->responseObj->status == 'approved') {

            $code = ($this->responseObj->response_code) ? intval($this->responseObj->response_code) : null;

            if (Errors::SUCCESS === $code) {
                $status = true;
            }
        }

        return $status;
    }

    /**
     * Try to fetch a description of the received Error Code
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
     * Return the parsed response
     *
     * @return mixed
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

        $this->responseObj = simplexml_load_string($response);
    }

    /**
     * Parse the POST data received from Genesis Notification
     */
    public function parseNotification($data)
    {
        if(!is_object($this->responseObj)) {
            $this->responseObj = new \stdClass();
        }

        foreach ($data as $var => $value) {
            $this->responseObj->$var = trim(urldecode($value));
        }
    }
}
<?php

namespace Genesis;


class Genesis_HTTP_Request extends Genesis_Base
{
    private $_body;
    private $_status;

    private $_context;

    /**
     * Check if cURL is available, if not - fallback to Native
     *
     */
    public function __construct()
    {
        if ($this->_isCurlAvailable())
        {
            $this->_context = new Genesis_HTTP_Request_cURL();
        }
        else
        {
            throw Genesis_Missing_Required_Component('cURL');
        }
    }

    /**
     * Load the Data From the Request
     */
    public function setRequest($request)
    {
        $this->_context->setRequest($request);
        $this->_context->setHeaders();
    }

    /**
     * Execute the request
     *
     */
    public function submitToGenesis()
    {
        $this->_context->Execute();

        $this->_status  = $this->_context->getStatus();
    }

    /**
     * Check whether cURL is available or not
     *
     * @return bool
     */
    private function _isCurlAvailable() {
        return function_exists('curl_version');
    }
}
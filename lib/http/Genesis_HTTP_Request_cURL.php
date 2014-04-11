<?php

namespace Genesis;


class Genesis_HTTP_Request_cURL extends Genesis_Base
{
    private $_handle;
    private $_apireq;

    public function __construct()
    {
        $this->_handle = curl_init();
    }

    public function __destruct()
    {
        curl_close($this->_handle);
    }

    public function setRequest($api_request)
    {
        $this->_apireq = $api_request;
    }

    public function getStatus()
    {
        return curl_getinfo($this->_handle, CURLINFO_HTTP_CODE);
    }

    public function setHeaders()
    {
        $this->setOpt(CURLOPT_TIMEOUT, 60);
        $this->setOpt(CURLOPT_ENCODING, 'gzip');
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);

        $this->setOpt(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $this->setOpt(CURLOPT_USERPWD, Genesis_Configuration::getUsername() . ':' . Genesis_Configuration::getPassword() );

        $this->setOpt(CURLOPT_URL, $this->_apireq->buildURL());
        $this->setOpt(CURLOPT_CUSTOMREQUEST, $this->_apireq->getType());

        if( ($this->_apireq->getType() == 'POST') && $this->_apireq->isNotEmpty() ) {
            $this->setOpt(CURLOPT_POSTFIELDS, $this->_apireq->getBody());
        }

        if ($this->_apireq->isSecure()) {
            $this->setOpt(CURLOPT_SSL_VERIFYPEER, true);
            $this->setOpt(CURLOPT_SSL_VERIFYHOST, 2);
            $this->setOpt(CURLOPT_CAINFO, Genesis_Configuration::getCertificateAuthority() );
        }

        if (Genesis_Configuration::getDebug())
        {
            $this->setOpt(CURLOPT_VERBOSE, true);
        }

        $this->setOpt(CURLOPT_USERAGENT, 'Genesis PHP Client v' . Genesis_Configuration::getVersion() );
    }

    public function Execute()
    {
        $response = curl_exec($this->_handle);

        if ($this->_apireq->isSecure()) {
            if (intval($this->getStatus()) == 0) {
                throw new Genesis_Exception_Invalid_SSL_Certificate_Authority();
            }
        }

        return $response;
    }

    private function setOpt($curlOpt, $curlValue)
    {
        curl_setopt($this->_handle, $curlOpt, $curlValue);
    }
} 
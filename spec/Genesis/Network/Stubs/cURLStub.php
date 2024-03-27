<?php

namespace spec\Genesis\Network\Stubs;

use Genesis\Network\cURL;
use spec\Genesis\Network\Stubs\Traits\NetworkAdapter;

class cURLStub extends cURL
{
    use NetworkAdapter;

    protected $fixtures_path = 'spec/fixtures/API/Response/Network/2/';

    /**
     * Mock the status
     * The curl resource is not available because of the fake request
     *
     * @return int
     */
    public function getStatus()
    {
        if (preg_match('#HTTP/[0-9.]+\s+([0-9]+)#', $this->getResponseHeaders(), $result)) {
            return (int) $result[1];
        }

        return 0;
    }

    public function execute()
    {
        $this->response = $this->fetch_response();

        $this->checkForErrors();

        list($this->responseHeaders, $this->responseBody) = explode("\r\n\r\n", $this->response, 2);
    }

    public function authorization($requestData)
    {
        return parent::authorization($requestData);
    }
}

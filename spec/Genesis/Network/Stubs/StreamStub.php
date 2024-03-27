<?php

namespace spec\Genesis\Network\Stubs;

use Genesis\Network\Stream;
use spec\Genesis\Network\Stubs\Traits\NetworkAdapter;

class StreamStub extends Stream
{
    use NetworkAdapter;

    protected $fixtures_path = 'spec/fixtures/API/Response/Network/1.1/';

    public function execute()
    {
        set_error_handler([$this, 'processErrors'], E_WARNING);

        $this->response = $this->fetch_response();

        list($this->responseHeaders, $this->responseBody) = explode("\r\n\r\n", $this->response, 2);

        restore_error_handler();
    }

    public function authorization($requestData)
    {
        return parent::authorization($requestData);
    }
}

<?php

namespace spec\Genesis\Api\Stubs\Base;

use Genesis\Genesis;
use spec\Genesis\Network\Stubs\Traits\NetworkAdapter;

class GenesisStub extends Genesis
{
    use NetworkAdapter;

    protected $response;

    protected $responseHeaders;

    protected $responseBody;

    protected $fixtures_path = 'spec/Fixtures/Api/Response/Network/2/';

    public function setResponse($value)
    {
        $this->responseCtx = $value;
    }

    public function setNetwork($value)
    {
        $this->networkCtx = $value;
    }

    public function setRequest($value)
    {
        $this->requestCtx = $value;
    }

    public function mockExecute()
    {
        // Build the previously set data
        $this->networkCtx->setApiCtxData(
            $this->requestCtx
        );

        // Simulate request
        $this->response = $this->fetch_response();
        list($this->responseHeaders, $this->responseBody) = explode("\r\n\r\n", $this->response, 2);

        // Set the request context
        $this->responseCtx->setRequestCtx(
            $this->requestCtx
        );

        // Parse the response
        $this->responseCtx->parseResponse(
            $this->networkCtx
        );

        // Store the Response Object into the Request
        // The Transaction type request will have access to the response after execute
        $this->request()->setResponse(
            $this->response()
        );
    }
}

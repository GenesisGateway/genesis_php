<?php

namespace spec\Genesis\API\Stubs\Base;

use Genesis\API\Request;

class RequestStub extends Request
{
    public function setResponse($value)
    {
        $this->response = $value;
    }
}

<?php

namespace spec\Genesis\API\Stubs\Base;

use Genesis\Genesis;

class GenesisStub extends Genesis
{
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
}

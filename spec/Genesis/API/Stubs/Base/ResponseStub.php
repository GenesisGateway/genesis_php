<?php

namespace spec\Genesis\API\Stubs\Base;

use Genesis\API\Response;

class ResponseStub extends Response
{
    public function isResponseTypeJson($headers)
    {
        return parent::isResponseTypeJson($headers);
    }
}

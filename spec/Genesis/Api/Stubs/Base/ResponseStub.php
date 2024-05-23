<?php

namespace spec\Genesis\Api\Stubs\Base;

use Genesis\Api\Response;

class ResponseStub extends Response
{
    public function isResponseTypeJson($headers)
    {
        return parent::isResponseTypeJson($headers);
    }
}

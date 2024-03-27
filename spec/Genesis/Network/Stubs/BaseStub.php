<?php

namespace spec\Genesis\Network\Stubs;

use Genesis\Network\Base;

/**
 * Class BaseStub
 * @package spec\Genesis\Network\Stubs
 *
 * @SuppressWarnings("unused")
 */
class BaseStub extends Base
{
    public function prepareRequestBody($requestData)
    {
        // TODO: Implement prepareRequestBody() method.
    }

    public function getStatus()
    {
        // TODO: Implement getStatus() method.
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }

    public function getContentType($requestDataFormat)
    {
        return $this->getRequestContentType($requestDataFormat);
    }

    public function authorization($requestData)
    {
        // TODO: Implement authorization() method.
    }
}

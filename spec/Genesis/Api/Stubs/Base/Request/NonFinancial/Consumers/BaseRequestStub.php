<?php

namespace spec\Genesis\Api\Stubs\Base\Request\NonFinancial\Consumers;

use Genesis\Api\Request\Base\NonFinancial\Consumers\BaseRequest as ConsumerBaseRequest;

/**
 * Class BaseRequestStub
 * @package spec\Genesis\Api\Stubs\Base\Request\NonFinancial\Consumers
 */
class BaseRequestStub extends ConsumerBaseRequest
{
    /**
     * BaseRequestStub constructor.
     */
    public function __construct()
    {
        parent::__construct('');
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}

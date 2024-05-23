<?php

namespace spec\Genesis\Api\Stubs\Base\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\Base\NonFinancial\TokenizationApi\BaseRequest as TokenizationApiBaseRequest;

/**
 * Class BaseRequestStub
 * @package spec\Genesis\Api\Stubs\Base\Request\NonFinancial\TokenizationApi
 */
class BaseRequestStub extends TokenizationApiBaseRequest
{
    /**
     * BaseRequestStub constructor.
     */
    public function __construct()
    {
        parent::__construct('test');
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }

    /**
     * @return \ArrayObject
     */
    public function getTreeStructure()
    {
        $this->populateStructure();

        return $this->treeStructure;
    }
}

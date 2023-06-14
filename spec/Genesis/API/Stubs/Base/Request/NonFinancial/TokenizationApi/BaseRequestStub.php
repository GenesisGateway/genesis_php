<?php

namespace spec\Genesis\API\Stubs\Base\Request\NonFinancial\TokenizationApi;

use Genesis\API\Request\Base\NonFinancial\TokenizationApi\BaseRequest as TokenizationApiBaseRequest;
use Genesis\Utils\Common;

/**
 * Class BaseRequestStub
 * @package spec\Genesis\API\Stubs\Base\Request\NonFinancial\TokenizationApi
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

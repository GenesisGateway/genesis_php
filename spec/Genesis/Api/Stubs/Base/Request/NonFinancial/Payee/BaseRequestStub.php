<?php

namespace spec\Genesis\Api\Stubs\Base\Request\NonFinancial\Payee;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;

class BaseRequestStub extends BaseRequest
{
    public $treeStructure;

    public function __construct()
    {
        parent::__construct('');
    }

    public function getRequestStructure()
    {
        return [];
    }

    public function setGetRequest()
    {
        parent::setGetRequest();
    }

    public function populateStructure()
    {
        parent::populateStructure();
    }
    public function initConfiguration()
    {
        parent::initConfiguration();
    }
}

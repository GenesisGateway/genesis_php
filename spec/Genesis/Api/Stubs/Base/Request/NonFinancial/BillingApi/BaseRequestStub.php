<?php

namespace spec\Genesis\Api\Stubs\Base\Request\NonFinancial\BillingApi;

use Genesis\Api\Request\Base\NonFinancial\BillingApi\BaseRequest;

class BaseRequestStub extends BaseRequest
{
    public function let()
    {
        $this->beAnInstanceOf(BaseRequestStub::class);
    }

    public function __construct()
    {
        parent::__construct('test', 'test');
    }

    public function checkArrayMaxSize($var, $maxSize, $message)
    {
        parent::checkArrayMaxSize($var, $maxSize, $message);
    }

    public function getRequestPaging()
    {
        return parent::getRequestPaging();
    }

    public function getRequestOrder()
    {
        return parent::getRequestOrder();
    }

    protected function getRequestStructure()
    {
    }

    protected function getRequestFilters()
    {
    }

    protected function getResponseFieldsAllowedValues()
    {
        return ['id', 'name'];
    }

    protected function getOrderByFieldAllowedValues()
    {
        return ['creationDate', 'name'];
    }
}

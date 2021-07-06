<?php

namespace spec\Genesis\API\Stubs\Base;

use Genesis\API\Request;
use Genesis\Utils\Common;

class RequestStub extends Request
{
    public function setResponse($value)
    {
        $this->response = $value;
    }

    public function setTreeStructure($structure)
    {
        $this->treeStructure = Common::createArrayObject($structure);
    }

    public function getTreeStructure()
    {
        return (array) $this->treeStructure;
    }

    public function allowedZeroAmount()
    {
        return true;
    }

    public function getTransformAmount($amount = '', $currency = '')
    {
        return $this->transformAmount($amount, $currency);
    }

    public function getMethodAllowedEmptyRequiredAttributes()
    {
        return $this->getAllowedEmptyRequiredAttributes();
    }

    public function executeProcessRequestParameters()
    {
        $this->processRequestParameters();
    }
}

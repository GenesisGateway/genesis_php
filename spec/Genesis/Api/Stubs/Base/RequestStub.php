<?php

namespace spec\Genesis\Api\Stubs\Base;

use Genesis\Api\Request;
use Genesis\Utils\Common;

class RequestStub extends Request
{
    protected $field;

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

    public function getTransformAmount($amount = '', $currency = '')
    {
        return $this->transformAmount($amount, $currency);
    }

    public function getMethodAllowedEmptyRequiredAttributes()
    {
        return $this->allowedEmptyNotNullFields();
    }

    public function executeProcessRequestParameters()
    {
        $this->processRequestParameters();
    }

    protected function allowedEmptyNotNullFields()
    {
        return [
            'amount' => Request\Base\Financial\Cards\CreditCard::REQUEST_KEY_AMOUNT
        ];
    }
}

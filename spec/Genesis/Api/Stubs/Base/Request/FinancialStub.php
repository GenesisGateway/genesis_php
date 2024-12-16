<?php

namespace spec\Genesis\Api\Stubs\Base\Request;

use Genesis\Api\Request\Base\Financial;
use Genesis\Utils\Common;

class FinancialStub extends Financial
{
    protected function getTransactionType()
    {
        return 'transaction_type';
    }

    protected function getPaymentTransactionStructure()
    {
        return ['stub' => 'financial'];
    }

    protected function setRequiredFields()
    {
        $requiredFields = ['transaction_id'];

        $this->requiredFields = Common::createArrayObject($requiredFields);
    }
}

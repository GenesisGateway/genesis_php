<?php

namespace spec\Genesis\Api\Stubs\Base\Request;

use Genesis\Api\Request\Base\Financial;

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
}

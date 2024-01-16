<?php

namespace spec\Genesis\API\Stubs\Base\Request;

use Genesis\API\Request\Base\Financial;

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

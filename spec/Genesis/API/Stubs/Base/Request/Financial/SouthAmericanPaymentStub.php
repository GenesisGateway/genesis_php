<?php

namespace spec\Genesis\API\Stubs\Base\Request\Financial;

use Genesis\API\Request\Base\Financial\SouthAmericanPayment;

/**
 * Class SouthAmericanPaymentStub
 *
 * Used to spec SouthAmericanPayment abstract class
 *
 * @package spec\Genesis\API\Base\Request\Financial
 */
class SouthAmericanPaymentStub extends SouthAmericanPayment
{
    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return static::class;
    }

    /**
     * @return array
     */
    public function getAllowedBillingCountries()
    {
        return [];
    }
}

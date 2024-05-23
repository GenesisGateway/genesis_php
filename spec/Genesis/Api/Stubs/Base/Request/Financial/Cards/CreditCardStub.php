<?php

namespace spec\Genesis\Api\Stubs\Base\Request\Financial\Cards;

use Genesis\Api\Request\Base\Financial\Cards\CreditCard;

/**
 * Class CreditCardStub
 *
 * Used to spec CreditCard abstract class
 *
 * @package spec\Genesis\Api\Base\Request\Financial\Cards
 */
class CreditCardStub extends CreditCard
{

    protected function getTransactionAttributes()
    {
        return [];
    }

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
    public function getPaymentTransactionStructure()
    {
        return [];
    }

    public function getHasAllowedEmptyNotNullFields()
    {
        return $this->hasAllowedEmptyFields();
    }
}

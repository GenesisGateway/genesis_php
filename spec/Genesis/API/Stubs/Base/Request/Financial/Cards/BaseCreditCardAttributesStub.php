<?php

namespace spec\Genesis\API\Stubs\Base\Request\Financial\Cards;

use Genesis\API\Request\Base\Financial\Cards\BaseCreditCardAttributes;

/**
 * Class BaseCreditCardAttributesStub
 *
 * Used to spec BaseCreditCardAttributes abstract class
 *
 * @package spec\Genesis\API\Base\Request\Financial\Cards
 */
class BaseCreditCardAttributesStub extends BaseCreditCardAttributes
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
}

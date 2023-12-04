<?php

namespace spec\Genesis\API\Stubs\Base\Request\Financial\Cards;

use Genesis\API\Request\Base\Financial\Cards\CreditCard3D;

/**
 * Class CreditCard3DStub
 *
 * Used to spec CreditCard3D abstract class
 *
 * @package spec\Genesis\API\Base\Request\Financial\Cards
 */
class CreditCard3DStub extends CreditCard3D
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

    public function getRequired3DSFieldsConditional()
    {
        return $this->required3DSFieldsConditional();
    }

    public function getRequired3DSFieldsGroups()
    {
        return $this->required3DSFieldsGroups();
    }
}

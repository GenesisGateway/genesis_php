<?php

namespace spec\Genesis\Api\Stubs\Traits\Validations\Request;

use Genesis\Api\Request\Base\Financial\Cards\CreditCard;
use Genesis\Api\Traits\Validations\Request\Validations;

class ValidationsZeroAmountStub
{
    use Validations;

    public function allowedEmptyNotNullFields()
    {
        return array(
            'amount' => CreditCard::REQUEST_KEY_AMOUNT
        );
    }

    public function getHasAllowedEmptyFields()
    {
        return $this->hasAllowedEmptyFields();
    }

    public function getIsNotNullZeroAmountAllowed($fieldName, $fieldValue)
    {
        return $this->isNotNullAndEmptyValueAllowed($fieldName, $fieldValue);
    }
}

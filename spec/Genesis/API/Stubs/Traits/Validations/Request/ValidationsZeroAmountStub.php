<?php

namespace spec\Genesis\API\Stubs\Traits\Validations\Request;

use Genesis\API\Request\Base\Financial\Cards\CreditCard;
use Genesis\API\Traits\Validations\Request\Validations;

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

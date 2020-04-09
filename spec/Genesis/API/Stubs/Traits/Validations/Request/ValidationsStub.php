<?php

namespace spec\Genesis\API\Stubs\Traits\Validations\Request;

use Genesis\API\Traits\Validations\Request\Validations;
use Genesis\Exceptions\InvalidMethod;

class ValidationsStub
{
    use Validations;

    public $test_field_1;
    public $test_field_2;
    public $test_field_3;

    public $test_group_1;
    public $test_group_2;

    public $parent_field;

    public $test_property;
    public $test_method;

    public $valid_array;

    public function publicValidate()
    {
        $this->validate();
    }

    public function setRequiredFields($requiredFields)
    {
        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    public function setRequiredFieldsValues($requiredFieldsValues)
    {
        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldsValues);
    }

    public function setValidateGroupRequirements($requiredFieldsGroups)
    {
        $this->requiredFieldsGroups = \Genesis\Utils\Common::createArrayObject($requiredFieldsGroups);
    }

    public function setValidateConditionalRequirements($requiredFieldsConditional)
    {
        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);
    }

    public function setValidateConditionalFieldsOr($requiredFieldsOR)
    {
        $this->requiredFieldsOR = \Genesis\Utils\Common::createArrayObject($requiredFieldsOR);
    }

    public function setValidateConditionalValuesRequirements($requiredFieldValuesConditional)
    {
        $this->requiredFieldValuesConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldValuesConditional);
    }

    public function setValidations($testArray)
    {
        $this->validations = $testArray;
    }

    public function getTestField1()
    {
        return $this->test_field_1;
    }
}

<?php

namespace Genesis\API\Traits\Validations\Request;

use Genesis\API\Request\Base\Financial\Cards\CreditCard;
use Genesis\API\Validators\Request\Base\Validator as RequestValidator;
use Genesis\Utils\Common as CommonUtils;

trait Validations
{

    /**
     * Store the names of the fields that are Required
     *
     * @var \ArrayObject
     */
    protected $requiredFields;

    /**
     * Store the names of the field values that are Required
     *
     * @var \ArrayObject
     */
    protected $requiredFieldValues;

    /**
     * Store the names of "conditionally" Required fields.
     *
     * @var \ArrayObject
     */
    protected $requiredFieldsConditional;

    /**
     * Store group name/fields where at least on the fields
     * is required
     *
     * @var \ArrayObject
     */
    protected $requiredFieldsGroups;

    /**
     * Store a OR relationship between fields, whether at
     * least of of them has to be filled in.
     *
     * @var \ArrayObject
     */
    protected $requiredFieldsOR;

    /**
     * Store the names of "conditionally" Required fields with expected values.
     *
     * @var \ArrayObject
     */
    protected $requiredFieldValuesConditional;

    /**
     * Stores properties and method responsible for current verification
     *
     * @var array
     */

    protected $validations  = [
        'requiredFields'                  => 'validateFieldRequirements',
        'requiredFieldValues'             => 'validateFieldValuesRequirements',
        'requiredFieldsGroups'            => 'validateGroupRequirements',
        'requiredFieldsConditional'       => 'validateConditionalRequirements',
        'requiredFieldsOR'                => 'validateConditionalFieldsOr',
        'requiredFieldValuesConditional'  => 'validateConditionalValuesRequirements'
    ];

    protected function validate()
    {
        foreach ($this->validations as $property => $method) {
            if (!empty($this->{$property})) {
                if (!method_exists($this, $method)) {
                    throw new \Genesis\Exceptions\InvalidClassMethod();
                }
                $this->{$method}();
            }
        }
    }

     /**
     * Validate that all required fields are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function validateFieldRequirements()
    {
        $this->requiredFields->setIteratorClass('RecursiveArrayIterator');

        $iterator = new \RecursiveIteratorIterator($this->requiredFields->getIterator());

        foreach ($iterator as $fieldName) {
            if ($this->isNotNullAndEmptyValueAllowed($fieldName, $this->$fieldName)) {
                // Bypass Not Null but Empty value evaluation allowed like 0
                continue;
            }

            if (empty($this->$fieldName)) {
                throw new \Genesis\Exceptions\ErrorParameter(
                    sprintf('Empty (null) required parameter: %s', $fieldName)
                );
            }
        }
    }

    /**
     * Validate that all required fields are populated with expected values
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    protected function validateFieldValuesRequirements()
    {
        $iterator = $this->requiredFieldValues->getArrayCopy();

        foreach ($iterator as $fieldName => $validator) {
            if ($validator instanceof RequestValidator) {
                $validator->run($this, $fieldName);

                continue;
            }

            if (CommonUtils::isValidArray($validator)) {
                if (!in_array($this->$fieldName, $validator)) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf(
                            'Required parameter %s is set to %s, but expected to be one of (%s)',
                            $fieldName,
                            $this->$fieldName,
                            implode(
                                ', ',
                                CommonUtils::getSortedArrayByValue($validator)
                            )
                        )
                    );
                }

                continue;
            }

            if ($this->$fieldName !== $validator) {
                throw new \Genesis\Exceptions\ErrorParameter(
                    sprintf(
                        'Required parameter %s is set to %s, but expected to be %s',
                        $fieldName,
                        $this->$fieldName,
                        $validator
                    )
                );
            }
        }
    }

    /**
     * Validate that the group fields in the request are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function validateGroupRequirements()
    {
        $fields = $this->requiredFieldsGroups->getArrayCopy();

        $emptyFlag = false;
        $groupsFormatted = [];

        foreach ($fields as $group => $groupFields) {
            $groupsFormatted[] = sprintf(
                '%s (%s)',
                ucfirst($group),
                implode(', ', $groupFields)
            );

            foreach ($groupFields as $field) {
                if (!empty($this->$field)) {
                    $emptyFlag = true;
                }
            }
        }

        if (!$emptyFlag) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'One of the following group/s of field/s must be filled in: %s%s',
                    PHP_EOL,
                    implode(
                        PHP_EOL,
                        $groupsFormatted
                    )
                ),
                true
            );
        }
    }

    /**
     * Validate that all fields (who depend on previously populated fields) are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function validateConditionalRequirements()
    {

        $fields = $this->requiredFieldsConditional->getArrayCopy();

        foreach ($fields as $fieldName => $fieldDependencies) {
            if (!isset($this->$fieldName)) {
                continue;
            }

            foreach ($fieldDependencies as $fieldValue => $fieldDependency) {
                if (is_array($fieldDependency)) {
                    if ($this->$fieldName != $fieldValue) {
                        continue;
                    }

                    foreach ($fieldDependency as $field) {
                        if ($this->isNotNullAndEmptyValueAllowed($field, $this->$field)) {
                            // Bypass Not Null but Empty value evaluation allowed like 0
                            continue;
                        }

                        if (empty($this->$field)) {
                            $fieldValue =
                                is_bool($this->$fieldName)
                                    ? var_export($this->$fieldName, true)
                                    : $this->$fieldName;

                            throw new \Genesis\Exceptions\ErrorParameter(
                                sprintf(
                                    '%s with value %s is depending on: %s, which is empty (null)!',
                                    $fieldName,
                                    $fieldValue,
                                    $field
                                )
                            );
                        }
                    }
                } elseif (empty($this->$fieldDependency)) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf(
                            '%s is depending on: %s, which is empty (null)!',
                            $fieldName,
                            $fieldDependency
                        )
                    );
                }
            }
        }
    }

    /**
     * Validate conditional requirement, where either one of the fields are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function validateConditionalFieldsOr()
    {
        $fields = $this->requiredFieldsOR->getArrayCopy();

        $definedFieldsCount = 0;

        foreach ($fields as $fieldName) {
            if (isset($this->$fieldName) && !empty($this->$fieldName)) {
                $definedFieldsCount++;
            }

            if ($definedFieldsCount > 1) {
                 throw new \Genesis\Exceptions\ErrorParameter(
                     'Only one of following parameters: ' .
                      implode(', ', array_values($fields)) .
                     ' is allowed.'
                 );
            }
        }

        if ($definedFieldsCount === 0) {
            throw new \Genesis\Exceptions\ErrorParameter(implode(', ', array_values($fields)));
        }
    }

    /**
     * Validate that all fields (who depend on previously populated fields)
     * are populated with expected values
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function validateConditionalValuesRequirements()
    {
        if (!isset($this->requiredFieldValuesConditional)) {
            return;
        }

        $fields = $this->requiredFieldValuesConditional->getArrayCopy();

        foreach ($fields as $parentFieldName => $parentFieldDependencies) {
            if (!isset($this->$parentFieldName)) {
                continue;
            }

            foreach ($parentFieldDependencies as $parentFieldValue => $childFieldsDependency) {
                if ($this->$parentFieldName != $parentFieldValue) {
                    continue;
                }

                $childFieldGroupValuesValidated = false;

                foreach ($childFieldsDependency as $childFieldDependency) {
                    $childFieldValuesValidated = true;

                    foreach ($childFieldDependency as $childFieldName => $childFieldValues) {
                        if ($childFieldValues instanceof RequestValidator) {
                            try {
                                $childFieldValues->run($this, $childFieldName);
                            } catch (\Genesis\Exceptions\InvalidArgument $e) {
                                $childFieldValuesValidated = false;
                            }

                            continue;
                        }

                        if (CommonUtils::isValidArray($childFieldValues)) {
                            if (!in_array($this->$childFieldName, $childFieldValues)) {
                                $childFieldValuesValidated = false;
                            }

                            continue;
                        }

                        if ($this->$childFieldName !== $childFieldValues) {
                            $childFieldValuesValidated = false;
                        }
                    }

                    if ($childFieldValuesValidated) {
                        $childFieldGroupValuesValidated = true;

                        break;
                    }
                }

                if (!$childFieldGroupValuesValidated) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf(
                            '%s with value %s is depending on group of params with specific values. ' .
                            'Please, refer to the official API documentation for %s transaction type.',
                            $parentFieldName,
                            $parentFieldValue,
                            method_exists($this, 'getTransactionType') ?
                                $this->getTransactionType() : 'the'
                        )
                    );
                }
            }
        }
    }

    /**
     * Indicates that the request has allowed fields with empty value
     * Like 0 value
     *
     * @return bool
     */
    protected function hasAllowedEmptyFields()
    {
        return method_exists($this, 'allowedEmptyNotNullFields') &&
            !empty($this->allowedEmptyNotNullFields());
    }

    /**
     * Check if the current validated field has 0 or empty value and pass the validation
     *
     * @param $fieldName
     * @param $fieldValue
     * @return bool
     */
    private function isNotNullAndEmptyValueAllowed($fieldName, $fieldValue)
    {
        if (!$this->hasAllowedEmptyFields()) {
            return false;
        }

        $allowedEmptyField = array_filter(
            array_keys($this->allowedEmptyNotNullFields()),
            function ($value) use ($fieldName, $fieldValue) {
                return $value === $fieldName && !is_null($fieldValue);
            }
        );

        return count($allowedEmptyField) > 0;
    }
}

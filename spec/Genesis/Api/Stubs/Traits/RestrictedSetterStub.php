<?php

namespace spec\Genesis\Api\Stubs\Traits;

use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class RestrictedSetterStub
 * @package spec\Genesis\Api\Stubs\Traits
 */
class RestrictedSetterStub
{
    use RestrictedSetter;

    /**
     * Property for testing into Spec
     *
     * @var string
     */
    public $test_value;

    /**
     * @param $field
     * @param $value
     * @param null $min
     * @param null $max
     * @return mixed
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function publicSetLimitedString($field, $value, $min = null, $max = null)
    {
        return $this->setLimitedString($field, $value, $min, $max);
    }

    /**
     * @param $field
     * @param $formats
     * @param $value
     * @param $errorMessage
     * @return RestrictedSetterStub
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function publicParseDate($field, $formats, $value, $errorMessage)
    {
        return $this->parseDate($field, $formats, $value, $errorMessage);
    }

    /**
     * @param $field
     * @param $allowed
     * @param $value
     * @param $errorMessage
     *
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function publicAllowedOptionsSetter($field, $allowed, $value, $errorMessage)
    {
        return $this->allowedOptionsSetter($field, $allowed, $value, $errorMessage);
    }

    /**
     * @param string $field
     * @param $value
     * @throws \Genesis\Exceptions\InvalidArgument
     * @return $this
     */
    public function publicParseAmount($field, $value)
    {
        return $this->parseAmount($field, $value);
    }
}

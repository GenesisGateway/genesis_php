<?php

namespace spec\Genesis\API\Stubs\Traits;

use Genesis\API\Traits\RestrictedSetter;

/**
 * Class RestrictedSetterStub
 * @package spec\Genesis\API\Stubs\Traits
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
}

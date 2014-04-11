<?php

namespace Genesis;

class Genesis_Base
{
    /**
     * Helper function - replace uppercase letter with
     * underscore, followed by small letter
     *
     * @param $string String  - uppercase string
     * @return String         - processed string
     */
    static function uppercaseToUnderscore($string)
    {
        return preg_replace("/(?<=[a-zA-Z])(?=[A-Z])/", "_", $string);
    }

    static function getErrorCode($error)
    {
        return Genesis_Errors::$error;
    }

    static function getErrorDescription($error_code)
    {
        return Genesis_Errors::getErrorDescription($error_code);
    }

    /**
     * Helper function - making sure we're not trying
     * to set empty configuration key/value.
     *
     * @param string $key   - configuration key
     * @param string $value - configuration value
     * @return bool
     */
    static function validateOption($key, $value)
    {
        if (empty($key) || empty($value))
        {
            if (array_key_exists(Genesis_Configuration::$vault, $key))
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }
}
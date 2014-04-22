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

    /**
     * Get Genesis Error Code
     *
     * @param $error
     * @return mixed
     */
    static function getErrorCode($error)
    {
        return Genesis_Errors::$error;
    }

    /**
     * Get description for an error, based
     * on the Error Code
     *
     * @param $error_code
     * @return string
     */
    static function getErrorDescription($error_code)
    {
        return Genesis_Errors::getErrorDescription($error_code);
    }

    /**
     * Recursive array cleanup
     */
    static function emptyValueRecursiveRemoval($haystack)
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = self::emptyValueRecursiveRemoval($haystack[$key]);
            }

            if (empty($haystack[$key])) {
                unset($haystack[$key]);
            }
        }

        return $haystack;
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
            if (array_key_exists($key, Genesis_Configuration::$vault))
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
<?php

namespace Genesis;

use \Genesis\API\Errors as Errors;
use \Genesis\Exceptions as Exceptions;

final class Base
{
    /**
     * Initialize and instantiate the desired request
     *
     * @param $request - name of the API request
     * @throws Exceptions\InvalidMethod()
     */
    static function loadRequest($request)
    {
        if (strpos($request, '\\') === false) {
            $request = sprintf('\Genesis\API\Request\%s', $request);
        }

        if ( class_exists($request) ) {
            return new $request;
        }
        else {
            throw new Exceptions\InvalidMethod();
        }
    }

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
     * @param $error - error_msg to retrieve error code
     * @return mixed
     */
    static function getErrorCode($error)
    {
        return Errors::$error;
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
        return Errors::getErrorDescription($error_code);
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
            if (array_key_exists($key, Configuration::$vault))
            {
                return false;
            }
        }
        else {
            return true;
        }
    }
}

<?php
/**
 * Various helper functions used across the project
 *
 * @package Genesis
 * @subpackage Utils
 */

namespace Genesis\Utils;

final class Common {

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
     * Helper function - iterate over array ($haystack) and
     * remove every key with empty value
     *
     * @param Array $haystack - input array
     * @return Array
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
     * Create ArrayObject ($target) from passed Array ($source_array)
     *
     * @param $source_array - input array
     * @return \ArrayObject
     */
    static function createArrayObject($source_array)
    {
        return new \ArrayObject($source_array, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Get PHP_VERSION_ID or defined it (for PHP < 5.2.7)
     *
     * @return int
     */
    static function getPHPVersion()
    {
        // PHP_VERSION_ID is available as of PHP 5.2.7, if our
        // version is lower than that, then emulate it
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);

            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        return PHP_VERSION_ID;
    }

} 
<?php
/*
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\Utils;

/**
 * Various helper functions used across the project
 *
 * @package    Genesis
 * @subpackage Utils
 */
final class Common
{
    /**
     * Helper for version_compare()
     *
     * @param string $version  - The version you want to check against
     * @param string $operator - Type of version check
     *
     * @return mixed
     */
    public static function compareVersions($version, $operator)
    {
        return version_compare(self::getPHPVersion(), $version, $operator);
    }

    /**
     * Helper to get the current PHP version
     *
     * @return int
     */
    public static function getPHPVersion()
    {
        // PHP_VERSION_ID is available as of PHP 5.2.7, if the current version is older than that - emulate it
        if (!defined('PHP_VERSION_ID')) {
            list($major, $minor, $release) = explode('.', PHP_VERSION);

            /**
             * Define PHP_VERSION_ID if its not present (unsupported version)
             *
             * format: major minor release
             */
            define('PHP_VERSION_ID', (($major * 10000) + ($minor * 100) + $release));
        }

        return (int)PHP_VERSION_ID;
    }

    /**
     * Convert PascalCase string to a SnakeCase
     * useful for argument parsing
     *
     * @param  string $input
     *
     * @return string
     */
    public static function pascalToSnakeCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);

        foreach ($matches[0] as &$match) {
            $match = ($match == strtoupper($match)) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $matches[0]);
    }

    /**
     * Get PascalCase to action/target array
     *
     * @param $input
     *
     * @return array
     */
    public static function resolveDynamicMethod($input)
    {
        $snakeCase = explode('_', self::pascalToSnakeCase($input));

        $result = [
            current(
                array_slice($snakeCase, 0, 1)
            ),
            implode(
                '_',
                array_slice($snakeCase, 1)
            )
        ];

        return $result;
    }

    /**
     * Convert SnakeCase to CamelCase
     *
     * @param string $input
     *
     * @return string
     */
    public static function snakeCaseToCamelCase($input)
    {
        return preg_replace_callback(
            '/(?:^|_)(.?)/',
            function ($value) {
                return strtoupper($value[1]);
            },
            $input
        );
    }

    /**
     * Helper function - iterate over array ($haystack) and
     * remove every key with empty value
     *
     * @param array $haystack - input array
     *
     * @return array
     */
    public static function emptyValueRecursiveRemoval($haystack)
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
     * @param $srcArray - input array
     *
     * @return \ArrayObject
     */
    public static function createArrayObject($srcArray)
    {
        return new \ArrayObject($srcArray, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Check if the passed argument is:
     * - Array
     * - Its not empty
     *
     * @param array $arr incoming array
     *
     * @return bool
     */
    public static function isValidArray($arr)
    {
        if (!is_array($arr) || empty($arr) || count($arr) < 1) {
            return false;
        }

        return true;
    }

    /**
     * Check if the passed key exists in the supplied array
     *
     * @param string $key
     * @param array $arr
     *
     * @return bool
     */
    public static function isArrayKeyExists($key, $arr)
    {
        if (!self::isValidArray($arr)) {
            return false;
        }

        return array_key_exists($key, $arr);
    }

    /**
     * Makes a copy of an array
     *
     * @param array $arr
     * @return array|null
     */
    public static function copyArray($arr)
    {
        if (!self::isValidArray($arr)) {
            return null;
        }

        return array_merge([], $arr);
    }

    /**
     * Sorts an array by value and returns a new instance
     *
     * @param array $arr
     * @return array
     */
    public static function getSortedArrayByValue($arr)
    {
        $duplicate = self::copyArray($arr);

        if ($duplicate === null) {
            return null;
        }

        asort($duplicate);

        return $duplicate;
    }

    /**
     * Appends items to an ArrayObject by key
     *
     * @param \ArrayObject $arrObj
     * @param string $key
     * @param array $values
     * @return \ArrayObject|null
     */
    public static function appendItemsToArrayObj(&$arrObj, $key, $values)
    {
        if (! $arrObj instanceof \ArrayObject) {
            return null;
        }

        $arr = $arrObj->getArrayCopy();

        $commonArrKeyValues =
            Common::isArrayKeyExists($key, $arr)
                ? $arr[$key]
                : [];

        $arr[$key] = array_merge($commonArrKeyValues, $values);

        return $arrObj = self::createArrayObject($arr);
    }

    /**
     * @param array $arr
     * @return array
     */
    public static function getArrayKeys($arr)
    {
        if (self::isValidArray($arr)) {
            return array_keys($arr);
        }

        return [];
    }

    /**
     * Check if the passed argument is a valid XML tag name
     *
     * @param string $tag
     *
     * @return bool
     */
    public static function isValidXMLName($tag)
    {
        if (!is_array($tag)) {
            return preg_match('/^[a-z_]+[a-z0-9\:\-\.\_]*[^:]*$/i', $tag, $matches) && reset($matches) == $tag;
        }

        return false;
    }

    /**
     * Evaluate a boolean expression from String
     * or return the string itself
     *
     * @param $string
     *
     * @return bool | string
     */
    public static function stringToBoolean($string)
    {
        $flag = filter_var($string, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($flag) {
            return true;
        } elseif (is_null($flag)) {
            return $string;
        }

        return false;
    }

    /**
     * Convert Boolean to String
     *
     * @param bool $bool
     *
     * @return string
     */
    public static function booleanToString($bool)
    {
        if (is_bool($bool)) {
            if ($bool) {
                return 'true';
            }

            return 'false';
        }

        return $bool;
    }

    /**
     * Check if a string is base64 Encoded
     *
     * @param string $input Data to verify if its valid base64
     * @return bool
     */
    public static function isBase64Encoded($input)
    {
        if ($input && @base64_encode(@base64_decode($input, true)) === $input) {
            return true;
        }

        return false;
    }

    /**
     * Check if an array has array items
     * @param array $arr
     * @return bool
     */
    public static function arrayContainsArrayItems($arr)
    {
        if (!self::isValidArray($arr)) {
            return false;
        }

        foreach ($arr as $item) {
            if (self::isValidArray($item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if the given class is Instantiable or not
     * Helps to prevent from creating an instance of an abstract class
     *
     * @param string $className
     * @return bool
     */
    public static function isClassAbstract($className)
    {
        if (!class_exists($className)) {
            return false;
        }

        $reflectionClass = new \ReflectionClass($className);

        return $reflectionClass->isAbstract();
    }

    /**
     * Retrieves all constants in a class in a list
     * @param string $className
     * @return array
     */
    public static function getClassConstants($className)
    {
        if (!class_exists($className)) {
            return [];
        }

        $reflection = new \ReflectionClass($className);

        return $reflection->getConstants();
    }

    /**
     * @param string $pattern
     * @return bool
     */
    public static function isRegexExpr($pattern)
    {
        return @preg_match($pattern, null) !== false;
    }
}

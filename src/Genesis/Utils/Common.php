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
    public static function checkRequirements()
    {
        // PHP version requirements
        if (self::compareVersions('5.3.2', '<')) {
            throw new \Exception(
                'Unsupported PHP version, please upgrade!' . PHP_EOL .
                'This library requires PHP version 5.3.2 or newer.'
            );
        }

        // BCMath requirements
        if (!function_exists('bcmul') || !function_exists('bcdiv')) {
            throw new \Exception(
                'BCMath extension is required!' . PHP_EOL .
                'Please install the extension or rebuild with "--enable-bcmath" option.'
            );
        }

        // Hash requirements
        if (!function_exists('hash')) {
            throw new \Exception(
                'Hash extension is required!' . PHP_EOL .
                'Please install the extension or rebuild with "--enable-hash" option.'
            );
        }

        // XMLWriter requirements
        if (\Genesis\Config::getInterface('builder') == 'xml') {
            if (!class_exists('XMLWriter')) {
                throw new \Exception(
                    'XMLWriter extension is required!' . PHP_EOL .
                    'Please install the extension or rebuild with "--enable-xmlwriter" option.'
                );
            }
        }

        // cURL requirements
        if (\Genesis\Config::getInterface('network') == 'curl') {
            if (!function_exists('curl_init')) {
                throw new \Exception(
                    'cURL interface is selected, but its not installed on your system!' . PHP_EOL .
                    'Please install the extension or select "stream" as your network interface.'
                );
            }
        }
    }

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
            define('PHP_VERSION_ID', ($major * 10000 + $minor * 100 + $release));
        }

        return PHP_VERSION_ID;
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

        $ret = reset($matches);

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
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
        return preg_replace_callback('/(?:^|_)(.?)/', function ($v) {
            return strtoupper($v[1]);
        }, $input);
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
     * @param $source_array - input array
     *
     * @return \ArrayObject
     */
    public static function createArrayObject($source_array)
    {
        return new \ArrayObject($source_array, \ArrayObject::ARRAY_AS_PROPS);
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
     * Check if the passed argument is a valid XML tag name
     *
     * @param $tag
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
        } else {
            return false;
        }
    }

    /**
     * Convert Boolean to String
     *
     * @param $bool
     *
     * @return mixed
     */
    public static function booleanToString($bool)
    {
        if (is_bool($bool)) {
            if ($bool) {
                return 'true';
            } else {
                return 'false';
            }
        }

        return $bool;
    }
}

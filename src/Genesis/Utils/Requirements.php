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
 * Check the system for dependencies
 *
 * @package Genesis\Utils
 */
final class Requirements
{
    /**
     * The earliest supported PHP Version
     *
     * @var string
     */
    protected static $minPHPVersion = '5.5.9';

    /**
     * Check if the current system fulfils the project's dependencies
     *
     * @throws \Exception
     */
    public static function verify()
    {
        // PHP interpreter version
        self::checkSystemVersion();

        // BCMath
        self::isFunctionExists('bcmul', self::getErrorMessage('bcmath'));
        self::isFunctionExists('bcdiv', self::getErrorMessage('bcmath'));

        // Filter
        self::isFunctionExists('filter_var', self::getErrorMessage('filter'));

        // Hash
        self::isFunctionExists('hash', self::getErrorMessage('hash'));

        // XMLReader
        self::isClassExists('XMLReader', self::getErrorMessage('xmlreader'));

        // XMLWriter
        if (\Genesis\Config::getInterface('builder') == 'xml') {
            self::isClassExists('XMLWriter', self::getErrorMessage('xmlwriter'));
        }

        // cURL
        if (\Genesis\Config::getInterface('network') == 'curl') {
            self::isFunctionExists('curl_init', self::getErrorMessage('curl'));
        }
    }

    /**
     * Check the PHP interpreter version we're currently running
     *
     * @throws \Exception
     */
    public static function checkSystemVersion()
    {
        if (\Genesis\Utils\Common::compareVersions(self::$minPHPVersion, '<')) {
            throw new \Exception(self::getErrorMessage('system'));
        }
    }

    /**
     * Check if function (passed by arg) exists
     *
     * @param $function
     * @param $error
     * @throws \Exception
     */
    public static function isFunctionExists($function, $error)
    {
        if (!function_exists($function)) {
            throw new \Exception($error);
        }
    }

    /**
     * Check if method exists in a given class
     *
     * @param string $method - Method name to check for
     * @param string $class  - Class to test against
     * @param string $error  - Error message to display
     * @throws \Exception
     */
    public static function isMethodExists($method, $class, $error)
    {
        if (!method_exists($method, $class)) {
            throw new \Exception($error);
        }
    }

    /**
     * Check if class (passed by arg) exists
     *
     * @param $class
     * @param $error
     * @throws \Exception
     */
    public static function isClassExists($class, $error)
    {
        if (!class_exists($class)) {
            throw new \Exception($error);
        }
    }

    /**
     * Get error message for certain type
     *
     * @param   string $name
     * @return  string
     */
    public static function getErrorMessage($name)
    {
        $messages = [
            'system'    => 'Unsupported PHP version, please upgrade!' . PHP_EOL .
                           'This library requires PHP version ' . self::$minPHPVersion . ' or newer.',
            'bcmath'    => 'BCMath extension is required!' . PHP_EOL .
                           'Please install the extension or rebuild with "--enable-bcmath" option.',
            'filter'    => 'Filter extensions is required!' . PHP_EOL .
                           'Please install the extension or rebuild with "--enable-filter" option.',
            'hash'      => 'Hash extension is required!' . PHP_EOL .
                           'Please install the extension or rebuild with "--enable-hash" option.',
            'xmlreader' => 'XMLReader extension is required!' . PHP_EOL .
                           'Please install the extension or rebuild with "--enable-xmlreader" option.',
            'xmlwriter' => 'XMLWriter extension is required!' . PHP_EOL .
                           'Please install the extension or rebuild with "--enable-xmlwriter" option.',
            'curl'      => 'cURL interface is selected, but its not installed on your system!' . PHP_EOL .
                           'Please install the extension or select "stream" as your network interface.'
        ];

        if (array_key_exists($name, $messages)) {
            return $messages[$name];
        }

        return '[' . $name . '] Missing project dependency!';
    }
}

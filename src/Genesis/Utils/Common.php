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
 * @package Genesis
 * @subpackage Utils
 */
final class Common
{
	static function checkRequirements()
	{
		// PHP version requirements
		if (self::compareVersions('5.3.0', '<')) {
			throw new \Exception('Unsupported PHP version. This projects requires PHP version > 5.3.0. Please upgrade!');
		}

		// cURL requirements
		if (\Genesis\GenesisConfig::getInterfaceSetup('network') == 'curl') {
			if (!function_exists('curl_init')) {
				throw new \Exception('cURL is selected, but its not installed on your system! You can use "stream_context" alternatively, or install the cURL PHP extension.');
			}
		}

		// XMLWriter requirements
		if (\Genesis\GenesisConfig::getInterfaceSetup('builder') == 'xmlwriter') {
			if (!class_exists('XMLWriter')) {
				throw new \Exception('XMLWriter is selected, but its not installed on your system!, You can use "domdocument" alternatively, or re-compile PHP with XML support!');
			}
		}
	}
    /**
     * Helper function - replace uppercase letter with
     * underscore, followed by small letter
     *
     * @param $string string  - uppercase string
     * @return string         - processed string
     */
    static function uppercaseToUnderscore($string)
    {
        return preg_replace("/(?<=[a-zA-Z])(?=[A-Z])/", "_", $string);
    }

    /**
     * Helper function - iterate over array ($haystack) and
     * remove every key with empty value
     *
     * @param array $haystack - input array
     * @return array
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
	 * Helper for version_compare()
	 *
	 * @param string $version  - The version you want to check against
	 * @param string $operator - Type of version check
	 *
	 * @return mixed
	 */
	static function compareVersions($version, $operator)
	{
		return version_compare(self::getPHPVersion(), $version, $operator);
	}

    /**
     * Get the current PHP version
     *
     * @return int
     */
    static function getPHPVersion()
    {
        // PHP_VERSION_ID is available as of PHP 5.2.7, if the current version is older than that - emulate it
        if (!defined('PHP_VERSION_ID')) {
            list($major, $minor, $release) = explode('.', PHP_VERSION);

            define('PHP_VERSION_ID', ($major * 10000 + $minor * 100 + $release));
        }

        return PHP_VERSION_ID;
    }

} 
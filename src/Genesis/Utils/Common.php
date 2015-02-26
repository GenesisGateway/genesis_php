<?php

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
		if (version_compare(self::getPHPVersion(), '5.3.0', '<')) {
			throw new \Exception('Unsupported PHP version, please upgrade!');
		}

		// cURL requirements
		if (\Genesis\GenesisConfig::getInterfaceSetup('network') == 'curl') {
			if (!function_exists('curl_init')) {
				throw new \Exception('cURL is selected, but its not installed on your system! You can use "stream_context" alternatively or install the cURL PHP extension.');
			}
		}

		// XMLWriter requirements
		if (\Genesis\GenesisConfig::getInterfaceSetup('builder') == 'xmlwriter') {
			if (!class_exists('XMLWriter')) {
				throw new \Exception('XMLWriter is selected, but its not installed on your system!, You can use "domdocument" alternatively or re-compile PHP with XML support!');
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
     * Get PHP_VERSION_ID or defined it (for PHP < 5.2.7)
     *
     * @return int
     */
    static function getPHPVersion()
    {
        // PHP_VERSION_ID is available as of PHP 5.2.7, if the current version is older than that - emulate it
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);

            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        return PHP_VERSION_ID;
    }

} 
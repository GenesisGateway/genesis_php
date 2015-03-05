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
namespace Genesis;

/**
 * Class GenesisConfig
 * @package Genesis
 *
 * @method static \Genesis\GenesisConfig getUsername()  Get the Username, set in configuration
 * @method static \Genesis\GenesisConfig getPassword()  Get the Password, set in the configuration
 * @method static \Genesis\GenesisConfig getToken()     Get the Terminal Token, set in configuration
 *
 */
final class GenesisConfig
{
	/**
	 * Library Version
	 */
	const VERSION   = '1.1.0';

    /**
     * Genesis base domain name
     */
    const DOMAIN    = 'e-comprocessing.net';

    /**
     * Default Protocol for the HTTP requests
     */
    const PROTOCOL  = 'https';

	/**
	 * Environment definitions
	 */
	const ENV_STAG = 'sandbox';
	const ENV_PROD = 'production';

    /**
     * Array storing all the configuration for this instance.
     *
     * @var Array
     */
    public static $vault = array (
        'environment'       => null,
        'token'             => null,
        'username'          => null,
        'password'          => null,
    );

    /**
     * Array storing interface choice
     *
     * @var array
     */
    public static $interfaces = array (
        'builder'   => 'xml_writer',
        'network'   => 'curl',
    );

    /**
     * Some requests are targeting different sub-domains.
     * This should map all available requests/sub-domains
     * for each configuration type (develop,sandbox,production)
     *
     * @var Array
     */
    public static $sub_domains = array (
        'gateway'   => array (
            'production'    => 'gate.',
            'sandbox'       => 'staging.gate.'
        ),
        'wpf'       => array (
            'production'    => 'wpf.',
            'sandbox'       => 'staging.wpf.',
        ),
    );

    /**
     * Dynamic Getters/Setter for getting/setting configuration parameters
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    final public static function __callStatic($method, $args)
    {
        $ConfigKey = strtolower(substr($method, 3));

        switch (substr($method, 0, 3))
        {
            case 'get' :
                if (isset(self::$vault[$ConfigKey])) {
                    return self::$vault[$ConfigKey];
                }
                break;
            case 'set' :
                self::$vault[$ConfigKey] = trim(reset($args));
                break;
        }

        return null;
    }

    /**
     * Get the CA PEM (needed for cURL)
     *
     * @return string - Path to the Genesis CA Bundle; false otherwise
     * @throws \Genesis\Exceptions\EnvironmentNotSet()
     */
    final public static function getCertificateBundle()
    {
	    $CABundle = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Certificates' . DIRECTORY_SEPARATOR . 'ca-bundle.pem';

        if (file_exists($CABundle)) {
	        return $CABundle;
        }

	    return false;
    }

    /**
     * Get the current Environment based on the the set variable
     *
     * @return mixed
     * @throws \Genesis\Exceptions\EnvironmentNotSet()
     */
    final public static function getEnvironment()
    {
        if (!array_key_exists('environment', self::$vault)) {
            throw new \Genesis\Exceptions\EnvironmentNotSet();
        }

	    $alternate_names = array('prod', 'production', 'live');

	    foreach ($alternate_names as $name) {
		    if (strcasecmp(self::$vault['environment'], $name) === 0) {
			    return self::ENV_PROD;
		    }
	    }

	    return self::ENV_STAG;
    }

    /**
     * Get Basic URL for Genesis Requests
     *
     * @param $protocol String - set the request protocol
     * @param $sub_domain String - preferred sub_domain
     * @param $port Integer - port of the server
     * @return String
     * @throws \Genesis\Exceptions\EnvironmentNotSet()
     */
    final public static function getEnvironmentURL($protocol = self::PROTOCOL, $sub_domain = 'gateway', $port = 443)
    {
	    if (self::getEnvironment() == self::ENV_PROD) {
		    $sub_domain = self::$sub_domains[$sub_domain][self::ENV_PROD];
	    }
	    else {
		    $sub_domain = self::$sub_domains[$sub_domain][self::ENV_STAG];
	    }

        return sprintf('%s://%s%s:%s', $protocol, $sub_domain, self::DOMAIN, $port);
    }


    /**
     * Get selected interface option
     *
     * @param $type - type of the interface
     *
     * @return mixed - interface name or false if non-existing
     */
    final public static function getInterfaceSetup($type)
    {
        if (array_key_exists($type, self::$interfaces)) {
            return self::$interfaces[$type];
        }

	    return false;
    }

	/**
	 * Network timeout.
	 *
	 * @note Hard-code for now
	 *
	 * @return int
	 */
	final public static function getNetworkTimeout()
	{
		return 60;
	}

    /**
     * Get the version of this Library API
     *
     * @return string
     */
    final public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Load settings from an ini File
     *
     * @param $settings_file String - path to an ini file containing the settings
     * @throws \Genesis\Exceptions\InvalidArgument()
     */
    final public static function loadSettings($settings_file)
    {
        if (file_exists($settings_file)) {
            $settings = parse_ini_file($settings_file, true);

            if (isset($settings['Genesis']) && is_array($settings['Genesis']) && sizeof($settings['Genesis']) > 1) {
                foreach ($settings['Genesis'] as $option => $value)
                {
                    if (array_key_exists($option, self::$vault)) {
                        self::$vault[$option] = $value;
                    }
                }
            }

            if (isset($settings['Interfaces']) && is_array($settings['Interfaces']) && sizeof($settings['Interfaces']) > 1) {
                foreach ($settings['Interfaces'] as $option => $value)
                {
                    if (array_key_exists($option, self::$interfaces)) {
                        self::$interfaces[$option] = $value;
                    }
                }
            }
        }
        else {
            throw new \Genesis\Exceptions\InvalidArgument('The provided configuration file is invalid!');
        }
    }
}

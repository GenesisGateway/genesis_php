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
 * Class Config
 *
 * Store/Retrieve configuration key/values across the Genesis library
 *
 * @package Genesis
 *
 * @method static \Genesis\Config getUsername()  Get the Username, set in configuration
 * @method static \Genesis\Config getPassword()  Get the Password, set in the configuration
 * @method static \Genesis\Config getToken()     Get the Terminal Token, set in configuration
 *
 */
final class Config
{
    /**
     * Library Version
     */
    const VERSION = '1.3.0';

    /**
     * Core configuration settings
     *
     * @var Array
     */
    public static $vault
        = array(
            'endpoint'      => null,
            'username'      => null,
            'password'      => null,
            'environment'   => null,
            'token'         => null,
        );

    /**
     * Interface settings
     *
     * @var array
     */
    public static $interfaces
        = array(
            'builder' => 'xml',
            'network' => 'curl',
        );

    /**
     * Some requests are targeting different sub-domains.
     * This should map all available requests/sub-domains
     * for each configuration type (develop,sandbox,production)
     *
     * @var Array
     */
    public static $domains
        = array(
            'gateway' => array(
                'production' => 'gate.',
                'sandbox'    => 'staging.gate.'
            ),
            'wpf'     => array(
                'production' => 'wpf.',
                'sandbox'    => 'staging.wpf.',
            ),
        );

    /**
     * Dynamic Getters/Setter for getting/setting configuration parameters
     *
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $configKey = strtolower(substr($method, 3));

        switch (substr($method, 0, 3)) {
            case 'get':
                if (isset(self::$vault[$configKey])) {
                    return self::$vault[$configKey];
                }
                break;
            case 'set':
                self::$vault[$configKey] = trim(reset($args));
                break;
        }

        return null;
    }

    /**
     * Get configuration for an interface
     *
     * @param $type - type of the interface
     *
     * @return mixed - interface name or false if non-existing
     */
    public static function getInterface($type)
    {
        if (array_key_exists($type, self::$interfaces)) {
            return self::$interfaces[$type];
        }

        return false;
    }

    /**
     * Set an interface
     *
     * @param string $interface Name of interface (e.g. builder, network)
     * @param string $value     Value for the new interface (e.g. xml, curl)
     *
     * @return bool
     */
    public static function setInterface($interface, $value)
    {
        if (array_key_exists($interface, self::$interfaces)) {
            self::$interfaces[$interface] = $value;

            return true;
        }

        return false;
    }

    /**
     * Get the CA PEM
     *
     * @return string - Path to the Genesis CA Bundle; false otherwise
     * @throws \Genesis\Exceptions\EnvironmentNotSet()
     */
    public static function getCertificateBundle()
    {
        $bundle = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Certificates' . DIRECTORY_SEPARATOR . 'ca-bundle.pem';

        if (file_exists($bundle)) {
            return $bundle;
        }

        return false;
    }

    /**
     * Get the current Environment based on the set variable
     *
     * @return mixed
     * @throws \Genesis\Exceptions\EnvironmentNotSet()
     */
    public static function getEnvironment()
    {
        if (!array_key_exists('environment', self::$vault)) {
            throw new \Genesis\Exceptions\EnvironmentNotSet();
        }

        $environment = strtolower(trim(self::$vault['environment']));

        $aliases = array(
            'prod',
            'production',
            'live'
        );

        foreach ($aliases as $name) {
            if (strcasecmp($environment, $name) === 0) {
                return \Genesis\API\Constants\Environments::PRODUCTION;
            }
        }

        return \Genesis\API\Constants\Environments::STAGING;
    }

    /**
     * Get the current Domain Endpoint based on the set variable
     *
     * @return string
     */
    public static function getEndpoint()
    {
        $endpoint = strtolower(trim(self::$vault['endpoint']));

        $aliases = array(
            'emerchantpay',
            'emerchantpay.net',
            'emp',
            'emp.net'
        );

        foreach ($aliases as $name) {
            if (strcasecmp($endpoint, $name) === 0) {
                return \Genesis\API\Constants\Endpoints::EMERCHANTPAY;
            }
        }

        return \Genesis\API\Constants\Endpoints::ECOMPROCESSING;
    }

    /**
     * Get a sub-domain host based on the environment
     *
     * @see self::$domains
     *
     * @param $sub
     * @return string
     *
     * @throws Exceptions\EnvironmentNotSet
     */
    public static function getSubDomain($sub)
    {
        if (isset(self::$domains[$sub])) {
            return self::$domains[$sub][self::getEnvironment()];
        }

        return null;
    }

    /**
     * Network timeout.
     *
     * @note Hard-code for now
     *
     * @return int
     */
    public static function getNetworkTimeout()
    {
        return 60;
    }

    /**
     * Get the version of this Library API
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Load settings from an ini File
     *
     * @param string $iniFile Path to an ini file containing the settings
     *
     * @throws \Genesis\Exceptions\InvalidArgument()
     */
    public static function loadSettings($iniFile)
    {
        if (!file_exists($iniFile)) {
            throw new \Genesis\Exceptions\InvalidArgument(
                'The provided configuration file is invalid!'
            );
        }

        $settings = parse_ini_file($iniFile, true);

        foreach ($settings['Genesis'] as $option => $value) {
            if (array_key_exists($option, self::$vault)) {
                self::$vault[$option] = $value;
            }
        }

        foreach ($settings['Interfaces'] as $option => $value) {
            if (array_key_exists($option, self::$interfaces)) {
                self::$interfaces[$option] = $value;
            }
        }
    }
}

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
    const VERSION = '1.2.0';

    /**
     * Default Protocol for the HTTP requests
     */
    const PROTOCOL = 'https';

    /**
     * Environment definition: TEST
     */
    const ENV_STAG = 'sandbox';

    /**
     * Environment definition: LIVE
     */
    const ENV_PROD = 'production';

    /**
     * Domain name for E-ComProcessing's Endpoint
     */
    const DOMAIN_ECP = 'e-comprocessing.net';

    /**
     * Domain name for eMerchantPay's Endpoint
     */
    const DOMAIN_EMP = 'emerchantpay.net';

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
    public static $sub_domains
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
        $ConfigKey = strtolower(substr($method, 3));

        switch (substr($method, 0, 3)) {
            case 'get':
                if (isset(self::$vault[$ConfigKey])) {
                    return self::$vault[$ConfigKey];
                }
                break;
            case 'set':
                self::$vault[$ConfigKey] = trim(reset($args));
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
     * Get Basic URL for Genesis Requests
     *
     * @param string    $protocol   set the request protocol
     * @param string    $sub_domain preferred sub_domain
     * @param int       $port       port of the server
     *
     * @return String
     * @throws \Genesis\Exceptions\EnvironmentNotSet()
     */
    public static function getEnvironmentURL(
        $protocol = self::PROTOCOL,
        $sub_domain = 'gateway',
        $port = 443
    ) {
        if (self::getEnvironment() == self::ENV_PROD) {
            $sub_domain = self::$sub_domains[$sub_domain][self::ENV_PROD];
        } else {
            $sub_domain = self::$sub_domains[$sub_domain][self::ENV_STAG];
        }

        return sprintf('%s://%s%s:%s', $protocol, $sub_domain, self::getEndpoint(), $port);
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

        $alternate_names = array(
            'prod',
            'production',
            'live'
        );

        foreach ($alternate_names as $name) {
            if (strcasecmp(trim(self::$vault['environment']), $name) === 0) {
                return self::ENV_PROD;
            }
        }

        return self::ENV_STAG;
    }

    /**
     * Get the current Domain Endpoint based on the set variable
     *
     * @return string
     */
    public static function getEndpoint()
    {
        $alternate_names = array(
            'emerchantpay',
            'emerchantpay.net',
            'emp',
            'emp.net'
        );

        foreach ($alternate_names as $name) {
            if (strcasecmp(trim(self::$vault['endpoint']), $name) === 0) {
                return self::DOMAIN_EMP;
            }
        }

        return self::DOMAIN_ECP;
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
     * @param string $settings_file Path to an ini file containing the settings
     *
     * @throws \Genesis\Exceptions\InvalidArgument()
     */
    public static function loadSettings($settings_file)
    {
        if (file_exists($settings_file)) {
            $settings = parse_ini_file($settings_file, true);

            if (isset($settings['Genesis']) && is_array($settings['Genesis'])) {
                foreach ($settings['Genesis'] as $option => $value) {
                    if (array_key_exists($option, self::$vault)) {
                        self::$vault[$option] = $value;
                    }
                }
            }

            if (isset($settings['Interfaces']) && is_array($settings['Interfaces'])) {
                foreach ($settings['Interfaces'] as $option => $value) {
                    if (array_key_exists($option, self::$interfaces)) {
                        self::$interfaces[$option] = $value;
                    }
                }
            }
        } else {
            throw new \Genesis\Exceptions\InvalidArgument(
                'The provided configuration file is invalid!'
            );
        }
    }
}

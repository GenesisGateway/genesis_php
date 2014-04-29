<?php

namespace Genesis;

use \Genesis\Exceptions as Exceptions;

final class Configuration
{
    /**
     * Current version
     */
    const VERSION   = '1.0.0';

    /**
     * Default Protocol for the HTTP requests
     */
    const PROTOCOL  = 'https';

    /**
     * Genesis base domain name
     */
    const DOMAIN    = 'e-comprocessing.net';

    /**
     * Array storing all the configuration for this instance.
     *
     * @var Array
     */
    public static $vault = array (
        'debug'             => null,
        'environment'       => null,
        'token'             => null,
        'username'          => null,
        'password'          => null,
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
                $ConfigValue = trim(reset($args));

                if (Base::validateOption($ConfigKey, $ConfigValue)) {
                    self::$vault[$ConfigKey] = $ConfigValue;
                }
                break;
        }

        return null;
    }

    /**
     * Get the current Environment
     *
     * @return mixed
     * @throws Exceptions\EnvironmentNotSet()
     */
    final public static function getEnvironment()
    {
        if (!array_key_exists('environment', self::$vault)) {
            throw new Exceptions\EnvironmentNotSet();
        }

        return self::$vault['environment'];
    }

    /**
     * Get the CA PEM (needed for cURL), based on the selected
     * enviorment
     *
     * @return string - Path to the PEM file with the certificates
     * @throws Exceptions\EnvironmentNotSet()
     */
    final public static function getCertificateAuthority()
    {
        $genesis_dir = dirname(__FILE__);

        switch (self::getEnvironment())
        {
            case 'production':
                return sprintf('%s/Certificates/genesis_production_verisign_ca.pem', $genesis_dir);
                break;
            case 'sandbox':
                return sprintf('%s/Certificates/genesis_sandbox_comodo_ca.pem', $genesis_dir);
                break;
            default:
                throw new Exceptions\EnvironmentNotSet();
        }
    }

    /**
     * Get Basic URL for Genesis Requests
     *
     * @param $protocol String - set the request protocol
     * @param $sub_domain String - preferred sub_domain
     * @param $port Integer - port of the server
     * @return String
     * @throws Exceptions\EnvironmentNotSet()
     */
    final public static function getEnvironmentURL($protocol = self::PROTOCOL, $sub_domain = 'gateway', $port)
    {
        switch (self::getEnvironment())
        {
            case 'production':
                $sub_domain = self::$sub_domains[$sub_domain]['production'];
                break;
            case 'sandbox':
                $sub_domain = self::$sub_domains[$sub_domain]['sandbox'];
                break;
            default:
                throw new Exceptions\EnvironmentNotSet();
        }

        if (intval($port) > 0) {
            return sprintf('%s://%s%s:%s', $protocol, $sub_domain, self::DOMAIN, $port);
        }
        else {
            return sprintf('%s://%s%s', $protocol, $sub_domain, self::DOMAIN);
        }
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
     */
    final public static function loadSettings($settings_file)
    {
        if (file_exists($settings_file)) {
            $settings = parse_ini_file($settings_file, true);

            var_dump($settings);

            if (isset($settings['Genesis']) && is_array($settings['Genesis']) && sizeof($settings['Genesis']) > 1) {
                foreach ($settings['Genesis'] as $option => $value)
                {
                    if (array_key_exists($option, self::$vault)) {
                        self::$vault[$option] = $value;
                    }
                }
            }
        }
    }
}

<?php
/**
 * GenesisConfig Object.
 *
 * @package Genesis
 * @subpackage GenesisConfig
 */
namespace Genesis;

use \Genesis\Exceptions as Exceptions;

final class GenesisConfig
{
    /**
     * Genesis base domain name
     */
    const DOMAIN    = 'e-comprocessing.net';

    /**
     * Default Protocol for the HTTP requests
     */
    const PROTOCOL  = 'https';

    /**
     * Current version
     */
    const VERSION   = '1.0.0';

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
     * Array storing wrapper choice
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
            default:
            case 'sandbox':
                return sprintf('%s/Certificates/genesis_sandbox_comodo_ca.pem', $genesis_dir);
                break;
        }
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
     * Get Basic URL for Genesis Requests
     *
     * @param $protocol String - set the request protocol
     * @param $sub_domain String - preferred sub_domain
     * @param $port Integer - port of the server
     * @return String
     * @throws Exceptions\EnvironmentNotSet()
     */
    final public static function getEnvironmentURL($protocol = self::PROTOCOL, $sub_domain = 'gateway', $port = 443)
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
                break;
        }

        return sprintf('%s://%s%s:%s', $protocol, $sub_domain, self::DOMAIN, $port);
    }


    /**
     * Get selected interface option
     *
     * @param $type - type of the interface
     *
     * @return mixed - string name
     */
    final public static function getInterfaceSetup($type)
    {
        if (array_key_exists($type, self::$interfaces)) {
            return self::$interfaces[$type];
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
     * @throws Exceptions\InvalidArgument()
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
            throw new Exceptions\InvalidArgument('The provided ini file is invalid or does not exist!');
        }
    }
}

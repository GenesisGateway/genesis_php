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
        'Debug'             => null,
        'Environment'       => null,
        'Token'             => null,
        'Username'          => null,
        'Password'          => null,
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
     * @throws Genesis_Exception_Invalid_Method
     * @return mixed
     */
    final public static function __callStatic($method, $args)
    {
        $ConfigKey = substr($method, 3);

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
        if (!isset(self::$vault['Environment']) || empty(self::$vault['Environment'])) {
            throw new Exceptions\EnvironmentNotSet();
        }

        return self::$vault['Environment'];
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
        switch (self::getEnvironment())
        {
            case 'production':
                return sprintf('%s/Certificates/genesis_production_global_ca.pem', ROOT_PATH);
                break;
            case 'sandbox':
                return sprintf('%s/Certificates/genesis_sandbox_comodo_ca.pem', ROOT_PATH);
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
}

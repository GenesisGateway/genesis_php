<?php

namespace Genesis;

final class Genesis_Configuration extends Genesis_Base
{
    /**
     * Version of this library
     */
    const VERSION   = '1.0.0';

    /**
     * Protocol for the HTTP requests
     */
    const PROTOCOL  = 'https';

    /**
     * The base domain for Genesis
     */
    const DOMAIN    = 'e-comprocessing.net';

    /**
     * Array storing all the configuration for this instance.
     *
     * @var array
     */
    public static $vault = array (
        'Debug'             => null,
        'Enviorment'        => null,
        'Token'             => null,
        'Username'          => null,
        'Password'          => null,
    );

    /**
     * Some requests are targeting different sub-domains.
     * This should map all available requests/sub-domains
     * for each configuration type (develop,sandbox,production)
     *
     * @var array
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
     * Dynamic Getters/Setter for the class
     *
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

                if (parent::validateOption($ConfigKey, $ConfigValue)) {
                    self::$vault[$ConfigKey] = $ConfigValue;
                }
                break;
            default :
                throw new Genesis_Exception_Invalid_Method($method);
        }
    }

    /**
     * Get the current Environment
     *
     * @return mixed
     */
    final public static function getEnviorment()
    {
        return self::$vault['Enviorment'];
    }

    /**
     * Get the CA PEM (needed for cURL), based on the selected
     * enviorment
     *
     * @return string - Path to the PEM file with the certificates
     * @throws Genesis_Exception_Environment_Not_Set
     */
    final public static function getCertificateAuthority()
    {
        switch (self::getEnviorment())
        {
            case 'production':
                return sprintf('%s/cert/genesis_production_global_ca.pem', ROOT_PATH);
                break;
            case 'sandbox':
                return sprintf('%s/cert/genesis_sandbox_comodo_ca.pem', ROOT_PATH);
                break;
            default:
                throw new Genesis_Exception_Environment_Not_Set();
        }
    }

    /**
     * Get Basic URL for Genesis Requests
     *
     * @param string $sub_domain - preferred sub_domain
     * @return string - formatted url: protocol, sub, domain
     * @throws Genesis_Exception_Environment_Not_Set
     */
    final public static function getEnviormentURL($sub_domain = 'gateway')
    {
        switch (self::getEnviorment())
        {
            case 'production':
                $url = self::$sub_domains[$sub_domain]['production'];
                break;
            case 'sandbox':
                $url = self::$sub_domains[$sub_domain]['sandbox'];
                break;
            default:
                throw new Genesis_Exception_Environment_Not_Set();
        }

        return sprintf('%s://%s%s', self::PROTOCOL, $url, self::DOMAIN);
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
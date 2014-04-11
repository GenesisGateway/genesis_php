<?php

namespace Genesis;

class Genesis_Configuration extends Genesis_Base
{
    const VERSION = '1.0.0';

    /**
     * Array storing all the configuration for this instance.
     *
     * @var array
     */
    static $vault;

    public function __construct()
    {
        Genesis_Configuration::$vault = array (
            'Debug'             => null,
            'Enviorment'        => null,
            'Token'             => null,
            'Username'          => null,
            'Password'          => null,
        );
    }

    /**
     * Dynamic Getters/Setter for the class
     *
     */
    static function __callStatic($method, $args) {
            $EtterType = substr($method, 0, 3);
            $ConfigKey = substr($method, 3);

            switch ($EtterType) {
                case 'get' :
                    if (isset(Genesis_Configuration::$vault[$ConfigKey]))
                    {
                        return Genesis_Configuration::$vault[$ConfigKey];
                    }
                    break;
                case 'set' :
                    $ConfigValue = trim($args[0]);

                    if (Genesis_Configuration::validateOption($ConfigKey,$ConfigValue))
                    {
                        Genesis_Configuration::$vault[$ConfigKey] = $ConfigValue;
                    }
                    break;
                default :
                    throw new Genesis_Exception_Invalid_Method();
            }
    }

    /**
     * Get the CA PEM (needed for cURL), depending
     * on the selected enviorment
     *
     * @return string - Path to the PEM file with the certificates
     */
    static function getCertificateAuthority()
    {
        switch (Genesis_Configuration::getEnviorment())
        {
            case 'production':
                return sprintf('%s/cert/genesis_production_global_ca.pem', ROOT_PATH);
            case 'sandbox':
                return sprintf('%s/cert/genesis_sandbox_comodo_ca.pem', ROOT_PATH);
        }
    }

    /**
     * Get the BASE url, depending on the selected enviorment
     *
     * @return string
     */
    static function getEnviormentURL()
    {
        switch (Genesis_Configuration::getEnviorment())
        {
            case 'sandbox':
                return 'https://staging.gate.e-comprocessing.net';
            case 'production':
                return 'https://gate.e-comprocessing.net';
        }
    }

    /**
     * Get the version of this Library API
     *
     * @return string
     */
    static function getVersion()
    {
        return self::VERSION;
    }
} 
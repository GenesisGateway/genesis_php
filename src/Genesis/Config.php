<?php

/**
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
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis;

use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Config
 *
 * Store/Retrieve configuration key/values across the Genesis library
 *
 * @package Genesis
 *
 * @method static string getUsername()          Get the Username, set in configuration
 * @method static string getPassword()          Get the Password, set in the configuration
 * @method static string getToken()             Get the Terminal Token, set in configuration
 * @method static bool   getForceSmartRouting() Get whether Smart Routing endpoint will be used for Financial types
 * @method static string getBillingApiToken()   Get the Billing API Token, set in configuration
 *
 * @method static null setUsername($value)        Set the Username
 * @method static null setPassword($value)        Set the Password
 * @method static null setToken($value)           Set the Terminal
 * @method static null setBillingApiToken($value) Set the Billing API Token
 */
final class Config
{
    /**
     * Library Version
     */
    const VERSION = '2.0.2';

    /**
     * Core configuration settings
     *
     * @var array
     */
    public static $vault = [
        'endpoint'            => null,
        'username'            => null,
        'password'            => null,
        'token'               => null,
        'environment'         => \Genesis\Api\Constants\Environments::STAGING,
        'force_smart_routing' => false,
        'billing_api_token'   => null
    ];

    /**
     * Interface settings
     *
     * @var array
     */
    public static $interfaces = [
        'builder' => 'xml',
        'network' => 'curl'
    ];

    /**
     * Some requests are targeting different sub-domains.
     * This should map all available requests/sub-domains
     * for each configuration type (develop,sandbox,production)
     *
     * @var array
     */
    public static $domains = [
        'gateway'      => [
            'production' => 'gate.',
            'sandbox'    => 'staging.gate.'
        ],
        'wpf'          => [
            'production' => 'wpf.',
            'sandbox'    => 'staging.wpf.'
        ],
        'kyc'          => [
            'production' => 'kyc.',
            'sandbox'    => 'staging.kyc.'
        ],
        'api_service'  => [
            'production' => 'prod.api.',
            'sandbox'    => 'staging.api.'
        ]
    ];

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
        list($action, $keySetting) = CommonUtils::resolveDynamicMethod($method);

        switch ($action) {
            case 'get':
                if (isset(self::$vault[$keySetting])) {
                    return self::$vault[$keySetting];
                }
                break;
            case 'set':
                self::$vault[$keySetting] = trim(reset($args));
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
     * Get the current Genesis Environment
     *
     * @return mixed
     */
    public static function getEnvironment()
    {
        return self::$vault['environment'];
    }

    /**
     * Set Environment
     *
     * @param   string  $environmentArg
     * @return  string
     *
     * @throws InvalidArgument
     */
    public static function setEnvironment($environmentArg)
    {
        $environmentArg = strtolower(trim($environmentArg));

        $aliases = [
            \Genesis\Api\Constants\Environments::STAGING    => [
                'test',
                'testing',
                'staging',
                \Genesis\Api\Constants\Environments::STAGING
            ],
            \Genesis\Api\Constants\Environments::PRODUCTION => [
                'live',
                'prod',
                'production',
                \Genesis\Api\Constants\Environments::PRODUCTION
            ]
        ];

        foreach ($aliases as $environment => $endpointAlias) {
            foreach ($endpointAlias as $alias) {
                if (stripos($environmentArg, $alias) !== false) {
                    return self::$vault['environment'] = $environment;
                }
            }
        }

        throw new InvalidArgument(
            'Invalid Environment'
        );
    }

    /**
     * Get the current Genesis Endpoint
     *
     * @return mixed
     */
    public static function getEndpoint()
    {
        return self::$vault['endpoint'];
    }

    /**
     * Set Genesis Endpoint
     *
     * @param   string  $endpointArg
     * @return  string
     *
     * @throws InvalidArgument
     */
    public static function setEndpoint($endpointArg)
    {
        $endpointArg = strtolower(trim($endpointArg));

        $aliases = [
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY      => [
                'emp',
                'emerchantpay',
                \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
            ],
            \Genesis\Api\Constants\Endpoints::ECOMPROCESSING    => [
                'ecp',
                'ecomprocessing',
                'e-comprocessing',
                \Genesis\Api\Constants\Endpoints::ECOMPROCESSING
            ]
        ];

        foreach ($aliases as $endpoint => $endpointAlias) {
            foreach ($endpointAlias as $alias) {
                if (stripos($endpointArg, $alias) !== false) {
                    return self::$vault['endpoint'] = $endpoint;
                }
            }
        }

        throw new InvalidArgument(
            'Invalid Endpoint'
        );
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
     * Set Force Smart Routing endpoint for Financial types
     *
     * @param $value
     * @return bool
     */
    public static function setForceSmartRouting($value)
    {
        return self::$vault['force_smart_routing'] = CommonUtils::toBoolean($value);
    }

    /**
     * Load settings from an ini File
     *
     * @param string $iniFile Path to an ini file containing the settings
     *
     * @throws InvalidArgument()
     */
    public static function loadSettings($iniFile)
    {
        if (!file_exists($iniFile)) {
            throw new InvalidArgument(
                'The provided configuration file is invalid or inaccessible!'
            );
        }

        $settings = parse_ini_file($iniFile, true);

        foreach ($settings['Genesis'] as $option => $value) {
            if (array_key_exists($option, self::$vault)) {
                $method = 'set' . CommonUtils::snakeCaseToCamelCase($option);

                self::{$method}($value);
            }
        }

        foreach ($settings['Interfaces'] as $option => $value) {
            if (array_key_exists($option, self::$interfaces)) {
                self::$interfaces[$option] = $value;
            }
        }
    }
}

<?php

namespace Genesis;

use \Genesis\API\Errors as Errors;
use \Genesis\Exceptions as Exceptions;
use \Genesis\Utils\Country as Country;

final class Base
{
    public static $Request;
    public static $Response;

    /**
     * Initialize and instantiate the desired request
     *
     * @param $request - name of the API request
     * @throws Exceptions\InvalidMethod()
     */
    static function loadRequest($request)
    {
        //if (strpos($request, '\\') !== false) {
        $request = sprintf('\Genesis\API\Request\%s', $request);
        //}

        if ( class_exists($request) ) {
            Base::$Request = new $request;
            return Base::$Request;
        }
        else {
            throw new Exceptions\InvalidMethod();
        }
    }

    static function Request()
    {
        return self::$Request;
    }

    static function Response()
    {
        return self::$Response;
    }

    /**
     * Get Genesis Error Code
     *
     * @param $error - error_msg to retrieve error code
     * @return mixed
     */
    static function getErrorCode($error)
    {
        return constant('\Genesis\API\Errors::' . $error);
    }

    /**
     * Get description for an error, based
     * on the Error Code
     *
     * @param $error_code
     * @return string
     */
    static function getErrorDescription($error_code)
    {
        return Errors::getErrorDescription($error_code);
    }

    /**
     * Get a country full name by an ISO-4217 code
     *
     * @param $iso_code - ISO-4217 compliant code of the country
     *
     * @return mixed - full name of the country
     */
    static function getFullCountryName($iso_code)
    {
        return Country::getCountryName($iso_code);
    }

    /*
     * Get a country ISO code, by its full name in English
     *
     * @param $country_name - Name of the country in plain English
     *
     * @return mixed - ISO-4217 country code
     */
    static function getCountryISOCode($country_name)
    {
        return Country::getCountryISO($country_name);
    }
}

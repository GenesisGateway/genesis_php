<?php
/**
 * Base class of Genesis
 *
 * @package Genesis
 */

namespace Genesis;

use \Genesis\API\Errors as Errors;
use \Genesis\API\Response as Response;
use \Genesis\Exceptions as Exceptions;
use \Genesis\Utils\Country as Country;

class Genesis
{
    /**
     * Store the Network Request Instance
     *
     * @var \Genesis\API\Request
     */
    public $requestContext;
    /**
     * Store the Network Request Instance
     *
     * @var \Genesis\API\Response
     */
    public $responseContext;
    /**
     * Store the Network Request Instance
     *
     * @var \Genesis\Network\Request
     */
    protected $networkContext;

    /**
     * Initialize and instantiate the desired request
     *
     * @param $request - name of the API request
     * @throws Exceptions\InvalidMethod()
     */
    public function __construct($request)
    {
        $request = sprintf('\Genesis\API\Request\%s', $request);

        if ( class_exists($request) ) {
            $this->requestContext = new $request;
        }
        else {
            throw new Exceptions\InvalidMethod();
        }
    }

    /**
     * Get request instance
     *
     * @return \Genesis\API\Request
     */
    public function request()
    {
        return $this->requestContext;
    }

    /**
     * Get Response instance
     *
     * @return \Genesis\API\Response
     */
    public function response()
    {
        return $this->responseContext;
    }

    /*
     * Send the request
     *
     */
    public function execute()
    {
        // Send the request
        $this->networkContext = new Network\Request($this->requestContext);
        $this->networkContext->setRequestData();
        $this->networkContext->sendRequest();

        // Parse the response
        $this->responseContext = new Response($this->networkContext);
    }

    /**
     * Get Genesis Error Code
     *
     * @param $error - error_msg to retrieve error code
     *
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

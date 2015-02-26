<?php

namespace Genesis;

/**
 * Base class of Genesis
 *
 * @package Genesis
 */
class Genesis
{
    /**
     * Store the Network Request Instance
     *
     * @var \Genesis\API\Request
     */
	protected $requestCtx;

    /**
     * Store the Network Response Instance
     *
     * @var \Genesis\API\Response
     */
	protected $responseCtx;

    /**
     * Store the Network Request Instance
     *
     * @var \Genesis\Network\Request
     */
    protected $networkCtx;

    /**
     * Initialize and instantiate the desired request
     *
     * @param $request - API Request name, please consult the README for a list of all requests
     *
     * @throws Exceptions\InvalidMethod()
     */
    public function __construct($request)
    {
        $request = sprintf('\Genesis\API\Request\%s', $request);

        if ( class_exists($request) ) {
            $this->requestCtx = new $request;
        }
        else {
            throw new \Genesis\Exceptions\InvalidMethod('The select request is invalid!');
        }
    }

    /**
     * Get request instance
     *
     * @return \Genesis\API\Request
     */
    public function request()
    {
        return $this->requestCtx;
    }

    /**
     * Get Response instance
     *
     * @return \Genesis\API\Response
     */
    public function response()
    {
        return $this->responseCtx;
    }

    /*
     * Send the request
     *
     * @return void
     */
    public function execute()
    {
        // Send the request
        $this->networkCtx = new Network\Request($this->requestCtx);
        $this->networkCtx->setRequestData();
        $this->networkCtx->sendRequest();

        // Parse the response
        $this->responseCtx = new \Genesis\API\Response($this->networkCtx);
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
     *
     * @return string
     */
    static function getErrorDescription($error_code)
    {
        return \Genesis\API\Errors::getErrorDescription($error_code);
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
        return \Genesis\Utils\Country::getCountryName($iso_code);
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
        return \Genesis\Utils\Country::getCountryISO($country_name);
    }
}

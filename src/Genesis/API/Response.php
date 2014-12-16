<?php
/**
 * Response handler - handles responses from Genesis Gateway
 *
 * @package Genesis
 * @subpackage API
 */

namespace Genesis\API;

use Genesis\Exceptions;
use Genesis\Utils\Currency as Currency;
use Genesis\Network\Request as Network;

class Response
{
    /**
     * Store parsed, response object
     *
     * @var \stdClass
     */
    public $responseObj;

    /**
     * Store the response raw data
     *
     * @var String
     */
    public $responseRaw;

    /**
     * Network Context Handle
     *
     * @var Network
     */
    private $networkContext;

    public function __construct(Network $networkContext)
    {
        $this->networkContext = $networkContext;

        if ( strlen($this->networkContext->getResponseBody()) > 0 ) {
            $this->parseResponse($this->networkContext->getResponseBody());
        }
    }

    /**
     * Check whether the request was successful
     *
     * Note: You should consult with the documentation
     * which transaction responses have status available.
     *
     * @return bool | null (on missing status)
     */
    public function isSuccessful()
    {
        $status = false;

	    $successfulStatuses = array('approved', 'pending_async', 'new');

        if (isset($this->responseObj->status) && in_array($this->responseObj->status, $successfulStatuses)) {
            $status = true;
        }

	    if (!isset($this->responseObj->status)) {
		    $status = null;
	    }

        return $status;
    }

	/**
	 * Check whether the transaction was partially approved
	 *
	 * @see Genesis_API_Documentation for more information
	 *
	 * @return bool
	 */
	public function isPartiallyApproved()
	{
		$status = false;

		if (isset($this->responseObj->partial_approval) && strval($this->responseObj->partial_approval) == 'true') {
			$status = true;
		}

		return $status;
	}

    /**
     * Try to fetch a description of the received Error Code
     *
     * @return string | null (if no code/issuer_code is available)
     */
    public function getErrorDescription()
    {
        if (isset($this->responseObj->code) && !empty($this->responseObj->code)) {
            return Errors::getErrorDescription($this->responseObj->code);
        }

        if (isset($this->responseObj->response_code) && !empty($this->responseObj->response_code)) {
            return Errors::getIssuerResponseCode($this->responseObj->response_code);
        }

	    return null;
    }

    /**
     * Get the raw Genesis output
     *
     * @return String
     */
    public function getResponseRaw()
    {
        return $this->responseRaw;
    }

    /**
     * Get the parsed response
     *
     * @return \stdClass
     */
    public function getResponseObject()
    {
        return $this->responseObj;
    }

	/**
	 * Get formatted amount (instead of ISO4217, return in float)
	 *
	 * @return String | null (if no amount&currency is available)
	 */
	public function getFormattedAmount()
	{
		if (isset($this->responseObj->currency) && !empty($this->responseObj->currency)) {
			if ( isset( $this->responseObj->amount ) && ! empty( $this->responseObj->amount ) ) {
				return Currency::exponentToReal( $this->responseObj->amount, $this->responseObj->currency );
			}
		}

		return null;
	}

	/**
	 * Get DateTime object from the timestamp inside the response
	 *
	 * @return \DateTime|null (if invalid timestamp)
	 */
	public function getFormattedTimestamp()
	{
		if (isset($this->responseObj->timestamp) && !empty($this->responseObj->timestamp)) {
			return new \DateTime($this->responseObj->timestamp);
		}

		return null;
	}

    /**
     * Parse Genesis response to SimpleXMLElement
     *
     * @param $response \SimpleXMLElement
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function parseResponse($response)
    {
        if (empty($response)) {
            throw new Exceptions\InvalidArgument();
        }

        $this->responseRaw = $response;
        $this->responseObj = simplexml_load_string($response);
    }
}
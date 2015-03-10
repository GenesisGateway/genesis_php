<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API;

/**
 * Response - process/format an incoming Genesis response
 *
 * @package Genesis
 * @subpackage API
 */
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

    public function __construct($networkContext = null)
    {
	    if (is_a($networkContext, '\Genesis\Network\Request')) {
		    $this->parseResponse( $networkContext->getResponseBody() );
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
		if (isset($this->responseObj->partial_approval) && strval($this->responseObj->partial_approval) == 'true') {
			return true;
		}

		return false;
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
				return \Genesis\Utils\Currency::exponentToReal( $this->responseObj->amount, $this->responseObj->currency );
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
     * @param string $response
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function parseResponse($response)
    {
        if (empty($response)) {
            throw new \Genesis\Exceptions\InvalidArgument('Invalid document!');
        }

        $this->responseRaw = $response;
        $this->responseObj = \Genesis\Utils\Common::parseXMLtoArrayObject($response);
    }
}
<?php
/**
 * An interface for every network abstraction (cURL, Stream etc.).
 *
 * @package Genesis
 * @subpackage Network
 */

namespace Genesis\Network;

interface NetworkInterface
{
    /**
     * Get HTTP Status code
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Get the full response (headers/body)
     *
     * @return mixed
     */
    public function getResponse();

    /**
     * Get response headers
     *
     * @return mixed
     */
    public function getResponseHeaders();

    /**
     * Get response body
     *
     * @return mixed
     */
    public function getResponseBody();

    /**
     * Set the request parameters
     *
     * @param $requestData
     *
     * @return mixed
     */
    public function prepareRequestBody($requestData);

    /**
     * Execute pre-set request
     *
     * @return mixed
     */
    public function execute();
}

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
     * @var mixed
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
     * @var \Genesis\Network
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
        // Verify system requirements
        \Genesis\Utils\Requirements::verify();

        // Initialize the request
        $request = sprintf('\Genesis\API\Request\%s', $request);

        if (class_exists($request)) {
            $this->requestCtx = new $request;
        } else {
            throw new \Genesis\Exceptions\InvalidMethod(
                'The selected transaction type is invalid!'
            );
        }

        // Initialize the Network
        $this->networkCtx = new \Genesis\Network();

        // Initialize Response Object
        $this->responseCtx = new \Genesis\API\Response();
    }

    /**
     * Get request instance
     *
     * @return mixed
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

    /**
     * Send the request
     *
     * @throws Exceptions\ErrorAPI
     * @throws Exceptions\InvalidArgument
     * @throws Exceptions\InvalidResponse
     */
    public function execute()
    {
        // Build the previously set data
        $this->networkCtx->setApiCtxData(
            $this->requestCtx
        );

        // Send the request
        $this->networkCtx->sendRequest();

        // Set the request context
        $this->responseCtx->setRequestCtx(
            $this->requestCtx
        );

        // Parse the response
        $this->responseCtx->parseResponse(
            $this->networkCtx->getResponseBody()
        );
    }
}

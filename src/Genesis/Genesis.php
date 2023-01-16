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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis;

use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request;
use Genesis\API\Response;
use Genesis\Exceptions\DeprecatedMethod;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidMethod;
use Genesis\Utils\Common;
use Genesis\Utils\Requirements;

/**
 * Base class of Genesis
 *
 * @package Genesis
 */
class Genesis
{
    const REQUEST_NAMESPACE = '\Genesis\API\Request\\';

    /**
     * Store the Network Request Instance
     *
     * @var mixed
     */
    protected $requestCtx;

    /**
     * Store the Network Response Instance
     *
     * @var Response
     */
    protected $responseCtx;

    /**
     * Store the Network Request Instance
     *
     * @var Network
     */
    protected $networkCtx;

    /**
     * Initialize and instantiate the desired request
     *
     * @param $request - API Request name, please consult the README for a list of all requests
     *
     * @throws InvalidMethod
     * @throws DeprecatedMethod
     * @throws InvalidArgument
     */
    public function __construct($request)
    {
        // Verify system requirements
        Requirements::verify();

        // Retrieve the library from request
        $request = $this->getRequestClass($request);

        // Validate the requested library
        $this->validate($request);

        // Initialize the Request library
        $this->requestCtx = new $request();

        // Initialize the Network
        $this->networkCtx = new Network();

        // Initialize Response Object
        $this->responseCtx = new Response();
    }

    /**
     * @param string $request
     *
     * @return string
     */
    protected function getRequestClass($request)
    {
        $parts = explode('\\', $request);
        $lastIndex = count($parts) - 1;

        switch ($parts[$lastIndex]) {
            case 'Void':
                $parts[$lastIndex] = 'Cancel';
                break;
        }

        return sprintf(
            self::REQUEST_NAMESPACE . '%s',
            implode('\\', $parts)
        );
    }

    /**
     * Validation of the request library request
     *
     * @param $request
     * @throws DeprecatedMethod
     * @throws InvalidMethod
     */
    protected function validate($request)
    {
        $deprecatedRequests = array_map(
            function ($request) {
                return self::REQUEST_NAMESPACE . $request;
            },
            Types::getDeprecatedRequests()
        );

        if (in_array($request, $deprecatedRequests)) {
            throw new DeprecatedMethod(
                'The selected transaction type is deprecated!'
            );
        }

        if (!class_exists($request)) {
            throw new InvalidMethod(
                'The selected transaction type is invalid!'
            );
        }

        if (Common::isClassAbstract($request)) {
            throw new InvalidMethod(
                'The selected transaction type is invalid, because it is abstract!'
            );
        }
    }

    /**
     * @param string $trxType
     * @param array $params
     * @return Genesis
     * @throws DeprecatedMethod
     * @throws InvalidArgument
     * @throws InvalidMethod
     */
    public static function financialFactory($trxType, $params = [])
    {
        $requestClass = Types::getFinancialRequestClassForTrxType($trxType);
        if ($requestClass === false) {
            throw new InvalidArgument(
                'The selected transaction type is invalid!'
            );
        }

        $genesis = new static($requestClass);

        foreach ($params as $name => $value) {
            $method = 'set' . Common::snakeCaseToCamelCase($name);

            if (call_user_func([ $genesis->request(), $method ], $value) === false) {
                throw new InvalidArgument(
                    'Invalid argument ' . $name . ' for transaction type ' . $trxType
                );
            }
        }

        return $genesis;
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
     * @return Response
     */
    public function response()
    {
        return $this->responseCtx;
    }

    /**
     * Send the request
     *
     * @throws Exceptions\ErrorAPI
     * @throws Exceptions\ErrorParameter
     * @throws Exceptions\InvalidClassMethod
     * @throws Exceptions\InvalidResponse
     * @throws InvalidArgument
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
            $this->networkCtx
        );

        // Store the Response Object into the Request
        // The Transaction type request will have access to the response after execute
        $this->request()->setResponse(
            $this->response()
        );
    }
}

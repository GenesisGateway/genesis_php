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

use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

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
        $request = $this->getRequestClass($request);

        if (!class_exists($request)) {
            throw new \Genesis\Exceptions\InvalidMethod(
                'The selected transaction type is invalid!'
            );
        }

        if (\Genesis\Utils\Common::isClassAbstract($request)) {
            throw new \Genesis\Exceptions\InvalidMethod(
                'The selected transaction type is invalid, because it is abstract!'
            );
        }
        $this->requestCtx = new $request;

        // Initialize the Network
        $this->networkCtx = new \Genesis\Network();

        // Initialize Response Object
        $this->responseCtx = new \Genesis\API\Response();
    }

    /**
     * @param string $request
     *
     * @return string
     * @throws \Genesis\Exceptions\DeprecatedMethod
     */
    protected function getRequestClass($request)
    {
        $parts = explode('\\', $request);
        $lastIndex = count($parts) - 1;

        switch ($parts[$lastIndex]) {
            case 'Void':
                $parts[$lastIndex] = 'Cancel';
                break;
            case 'AVS':
            case 'INPay':
            case 'ABNiDEAL':
                $this->throwDeprecatedTransactionType();
                break;
            case 'Payin':
            case 'Payout':
                if ($this->getParentClass($parts, $lastIndex) === 'Citadel') {
                    $this->throwDeprecatedTransactionType();
                }
                break;
            case 'oBeP':
                if ($this->getParentClass($parts, $lastIndex) === 'PayByVouchers') {
                    $this->throwDeprecatedTransactionType();
                }
                break;
        }

        return sprintf(
            '\Genesis\API\Request\%s',
            implode('\\', $parts)
        );
    }

    /**
     * @param array $classParts
     * @param int $lastIndex Index of the last element in the array
     *
     * @return string Returns empty string, if there is no parent class
     */
    protected function getParentClass($classParts, $lastIndex)
    {
        return isset($classParts[$lastIndex - 1]) ? $classParts[$lastIndex - 1] : '';
    }

    /**
     * @throws \Genesis\Exceptions\DeprecatedMethod
     */
    protected function throwDeprecatedTransactionType()
    {
        throw new \Genesis\Exceptions\DeprecatedMethod(
            'The selected transaction type is deprecated!'
        );
    }

    /**
     * @param string $trxType
     * @param array $params
     * @throws \Genesis\Exceptions\InvalidArgument
     * @return Genesis
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
            $this->networkCtx
        );
    }
}

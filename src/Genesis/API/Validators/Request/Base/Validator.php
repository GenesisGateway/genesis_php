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

namespace Genesis\API\Validators\Request\Base;

use Genesis\Utils\Common as CommonUtils;

/**
 * Class Validator
 * @package Genesis\API\Validators\Request\Base
 */
abstract class Validator
{
    /**
     * API Request Instance
     *
     * @var \Genesis\API\Request
     */
    protected $request;

    /**
     * Validation error message
     *
     * @var string|null
     */
    protected $message;

    /**
     * Request field name to validate
     *
     * @var string
     */
    protected $field;

    /**
     * Validator constructor.
     *
     * @param null|string $message
     */
    public function __construct($message = null)
    {
        $this->message = $message;
    }

    /**
     * @param \Genesis\API\Request $request
     * @param string $field
     * @return void
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function run($request, $field)
    {
        $this->request = $request;
        $this->field   = $field;

        if (!$this->validate()) {
            $this->throwInvalidArgument();
        }
    }

    /**
     * Execute field name validation
     *
     * @return bool
     */
    abstract protected function validate();

    /**
     * @return void
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    protected function throwInvalidArgument()
    {
        $exceptionMessage =
            $this->message
                ? sprintf($this->message, $this->field)
                : "Please check input data for errors. '{$this->field}' has invalid format";

        throw new \Genesis\Exceptions\InvalidArgument($exceptionMessage);
    }

    /**
     * @return mixed|null
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function getRequestValue()
    {
        if (!property_exists($this->request, $this->field)) {
            throw new \Genesis\Exceptions\ErrorParameter("Property {$this->field} not found in API Request");
        }

        $method = CommonUtils::snakeCaseToCamelCase($this->field);

        return call_user_func([$this->request, "get$method"]);
    }
}

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
namespace Genesis\Exceptions;

/**
 * Class ErrorAPI
 *
 * Used to indicate an unsuccessful API request
 *
 * For example - invalid card, invalid data, insufficient funds etc.
 *
 * @package Genesis\Exceptions
 */
class ErrorAPI extends \Exception
{
    /**
     * Construct
     *
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = '', $code = 0, $previous = null)
    {
        $error          = empty($message) ? 'Unknown error' : $message;
        $description    = \Genesis\API\Constants\Errors::getErrorDescription($code);

        $message = 'Message: ' . $error . PHP_EOL .
                   'Details: ' . $description;

        parent::__construct($message, $code, $previous);
    }
}

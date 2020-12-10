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

namespace Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait Method
 * @package Genesis\API\Traits\Request\Financial\Threeds\V2
 *
 * @method string getThreedsV2MethodCallbackUrl()   3DS-Method related parameters for any callbacks and notifications
 */
trait Method
{
    /**
     * 3DS-Method related parameters for any callbacks and notifications.
     *
     * @var string $threeds_v2_method_callback_url
     */
    protected $threeds_v2_method_callback_url;

    /**
     * 3DS-Method related parameters for any callbacks and notifications
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2MethodCallbackUrl($value)
    {
        $url = filter_var($value, FILTER_VALIDATE_URL);

        if ($url === false) {
            throw new InvalidArgument('Invalid value given for threeds_v2_method_callback_url.');
        }

        $this->threeds_v2_method_callback_url = $url;

        return $this;
    }

    /**
     * Get the Threeds Method node structure
     *
     * @return array
     */
    protected function getMethodAttributes()
    {
        return [
            'callback_url' => $this->threeds_v2_method_callback_url
        ];
    }
}

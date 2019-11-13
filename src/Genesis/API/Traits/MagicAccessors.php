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

namespace Genesis\API\Traits;

use Genesis\Exceptions\InvalidMethod;
use Genesis\Utils\Common as CommonUtils;

/**
 * Trait MagicAccessors
 *
 * Provides magic setters and getters for existing fields
 *
 * @package Genesis\API\Traits
 */
trait MagicAccessors
{
    /**
     * Convert Pascal to Camel case and set the correct property
     *
     * @param $method
     * @param $args
     *
     * @throws InvalidMethod
     * @return mixed
     */
    public function __call($method, $args)
    {
        list($action, $target) = CommonUtils::resolveDynamicMethod($method);

        switch ($action) {
            case 'get':
                if (property_exists($this, $target)) {
                    return $this->$target;
                }
                break;
            case 'set':
                if (property_exists($this, $target)) {
                    $this->$target = reset($args);
                    return $this;
                }
                break;
        }

        throw new InvalidMethod(
            sprintf(
                'You\'re trying to call a non-existent method %s of class %s!',
                $method,
                static::class
            )
        );
    }
}

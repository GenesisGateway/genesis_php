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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Builders;

use Genesis\Exceptions\InvalidArgument;
use Genesis\Interfaces\Builder;

/**
 * Class Form
 *
 * Converts array to HTTP query string
 *
 * @package Genesis\Builders
 */
class Form implements Builder
{
    /**
     * The query string content
     *
     * @var string $content
     */
    private $content;

    public function getOutput()
    {
        return $this->content;
    }

    /**
     * Generate the query from array
     *
     * @param array $structure
     * @return mixed|void
     * @throws InvalidArgument
     */
    public function populateNodes($structure)
    {
        if (!is_array($structure) || empty($structure)) {
            throw new InvalidArgument('Invalid data/tree');
        }

        $this->content = http_build_query($structure, '', '&', PHP_QUERY_RFC1738);
    }
}

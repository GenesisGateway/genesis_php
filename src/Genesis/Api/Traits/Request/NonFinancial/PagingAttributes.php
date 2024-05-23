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

namespace Genesis\Api\Traits\Request\NonFinancial;

/**
 * Trait PagingAttributes
 * @package Genesis\Api\Traits\Request\NonFinancial
 *
 * @method int getPage() Get the page within the paginated result
 * @method int getPerPage() Get number of entities on page
 */
trait PagingAttributes
{
    /**
     * The page within the paginated result
     * defaults to 1
     *
     * @var int $page
     */
    protected $page;

    /**
     * Number of entities on page
     * default to 100
     *
     * @var int $per_page
     */
    protected $per_page;

    /**
     * Set the page within the paginated result
     *
     * @param $value
     * @return $this
     */
    public function setPage($value)
    {
        $this->page = (int) $value;

        return $this;
    }

    /**
     * Set the number of elements per page
     *
     * @param $value
     * @return $this
     */
    public function setPerPage($value)
    {
        $this->per_page = (int) $value;

        return $this;
    }

    /**
     * GraphQL code to request paging information
     *
     * @return string
     */
    protected function pagingGraphQlFields()
    {
        return 'paging {
                    page
                    perPage
                    pagesCount
                    totalCount
                }';
    }
}

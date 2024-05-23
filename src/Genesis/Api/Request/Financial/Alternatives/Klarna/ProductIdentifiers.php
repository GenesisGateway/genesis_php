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

namespace Genesis\Api\Request\Financial\Alternatives\Klarna;

/**
 * Class ProductIdentifiers
 *
 * Alternative payment method
 *
 * @package Genesis\Api\Request\Financial\Alternatives\Klarn
 */
class ProductIdentifiers
{
    /**
     * Brand
     * @var string
     */
    protected $brand;

    /**
     * Category path
     * @var string
     */
    protected $category_path;

    /**
     * Global trade item number
     * @var string
     */
    protected $global_trade_item_number;

    /**
     * Manufacturer part number
     * @var string
     */
    protected $manufacturer_part_number;


    public function setBrand($value)
    {
        $this->brand = $value;
        return $this;
    }

    public function setCategoryPath($value)
    {
        $this->category_path = $value;
        return $this;
    }

    public function setGlobalTradeItemNumber($value)
    {
        $this->global_trade_item_number = $value;
        return $this;
    }

    public function setManufacturerPartNumber($value)
    {
        $this->manufacturer_part_number = $value;
        return $this;
    }

    public function toArray()
    {
        return [
            'brand'                    => $this->brand,
            'category_path'            => $this->category_path,
            'global_trade_item_number' => $this->global_trade_item_number,
            'manufacturer_part_number' => $this->manufacturer_part_number
        ];
    }
}

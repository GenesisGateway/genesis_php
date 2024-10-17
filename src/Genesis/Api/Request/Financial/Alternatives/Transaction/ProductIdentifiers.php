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

namespace Genesis\Api\Request\Financial\Alternatives\Transaction;

use Genesis\Api\Traits\MagicAccessors;

/**
 * Class ProductIdentifiers
 *
 * Handles product identifiers for alternative payment methods.
 *
 * @package Genesis\Api\Request\Financial\InvoicePaymentMethods\Invoice
 * @method void   setBrand(string $value)                  Set the brand of the product.
 * @method void   setCategoryPath(string $value)           Set the category path of the product.
 * @method void   setGlobalTradeItemNumber(string $value)  Set the global trade item number of the product.
 * @method void   setManufacturerPartNumber(string $value) Set the manufacturer part number of the product.
 * @method string getBrand()                               Get the brand of the product.
 * @method string getCategoryPath()                        Get the category path of the product.
 * @method string getGlobalTradeItemNumber()               Get the global trade item number of the product.
 * @method string getManufacturerPartNumber()              Get the manufacturer part number of the product.
 */
class ProductIdentifiers
{
    use MagicAccessors;

    /**
     * Brand of the product.
     * @var string
     */
    protected $brand;

    /**
     * Category path of the product.
     * @var string
     */
    protected $category_path;

    /**
     * Global trade item number of the product.
     * @var string
     */
    protected $global_trade_item_number;

    /**
     * Manufacturer part number of the product.
     * @var string
     */
    protected $manufacturer_part_number;

    /**
     * Convert the product identifiers to an array.
     *
     * @return array The product identifiers as an array.
     */
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

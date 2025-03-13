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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\NonFinancial\Alternatives\Klarna;

use Genesis\Api\Request\Base\NonFinancial\Alternatives\Klarna\BaseRequest;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Items;
use Genesis\Api\Traits\Request\Financial\Alternatives\Invoice\InvoiceItemsTrait;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Api\Traits\Request\Financial\Alternatives\Invoice\InvoiceValidation;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidClassMethod;

/**
 * Class UpdateItems
 * @package Genesis\Api\Request\NonFinancial\Alternatives\Klarna
 *
 * @method mixed getAmount()
 */
class UpdateItems extends BaseRequest
{
    use PaymentAttributes;
    use InvoiceValidation;
    use InvoiceItemsTrait;

    /**
     * UpdateItems constructor.
     *
     * @param string $builderInterface
     */
    public function __construct($builderInterface = Builder::XML)
    {
        parent::__construct($builderInterface);

        $this->items = new Items();
    }

    /**
     * Init configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        parent::initBaseConfiguration('klarna/update_order_items');
    }

    /**
     * Return the structure of the request
     *
     * @throws InvalidArgument
     * @throws ErrorParameter
     */
    protected function getRequestStructure()
    {
        $this->items->setCurrency($this->currency);

        return array_merge(
            [
                'amount'   => \Genesis\Utils\Currency::amountToExponent($this->amount, $this->currency)
            ],
            $this->items instanceof Items ? $this->items->toArray() : []
        );
    }

    /**
     * Return the parent node
     *
     * @return string
     */
    protected function getParentNode()
    {
        return 'update_order_items_request';
    }

    /**
     * Set the required fields for the request
     *
     * @return array
     */
    protected function setRequestRequiredFields()
    {
        return [
            'amount'
        ];
    }

    /**
     * Check if the items are valid
     *
     * @return void
     * @throws ErrorParameter
     * @throws InvalidArgument
     * @throws InvalidClassMethod
     */
    protected function checkRequirements()
    {
        $this->items->setCurrency($this->currency);
        parent::checkRequirements();

        $this->validateItems();
    }
}

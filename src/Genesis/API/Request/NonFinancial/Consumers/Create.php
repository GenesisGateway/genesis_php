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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API\Request\NonFinancial\Consumers;

use Genesis\API\Request\Base\NonFinancial\Consumers\BaseRequest as ConsumerBaseRequest;
use Genesis\API\Traits\Request\CustomerAddress\BillingInfoAttributes;
use Genesis\API\Traits\Request\CustomerAddress\ShippingInfoAttributes;

/**
 * Class Create
 *
 * Creates a consumer based on email address. Optionally, one can provide billing and shipping address.
 * Addresses will be used, if none given, in Processing or WPF APIs.
 *
 * @package Genesis\API\Request\NonFinancial\Consumers
 *
 * @method string getEmail()
 * @method Create setEmail(string $email)
 */
class Create extends ConsumerBaseRequest
{
    use BillingInfoAttributes, ShippingInfoAttributes;

    /**
     * @var string
     */
    protected $email;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('create_consumer');
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'email'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'email'            => $this->email,
            'billing_address'  => $this->getBillingAddressParamsStructure(),
            'shipping_address' => $this->getShippingAddressParamsStructure()
        ];
    }
}

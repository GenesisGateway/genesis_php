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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Exceptions\InvalidArgument;
use spec\SharedExamples\Faker;

/**
 * Trait OrderAttributesExamples
 *
 * Shared examples for the merchant order_id attribute (OrderAttributes trait).
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait OrderAttributesExamples
{
    private $orderIdMaxLength = 255;

    public function it_should_not_fail_with_order_id_attribute()
    {
        $this->setRequestParameters();
        $this->setOrderId(Faker::getInstance()->bothify('order-########'));
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_order_id_attribute()
    {
        $orderId = Faker::getInstance()->bothify('order-########');

        $this->setRequestParameters();
        $this->setOrderId($orderId);
        $this->getDocument()->shouldContain('<order_id>' . $orderId . '</order_id>');
    }

    public function it_should_set_and_get_order_id_attribute()
    {
        $orderId = Faker::getInstance()->bothify('order-########');

        $this->setOrderId($orderId);
        $this->getOrderId()->shouldBe($orderId);
    }

    public function it_should_not_fail_when_unset_order_id()
    {
        $this->shouldNotThrow()->during('setOrderId', [null]);
    }

    public function it_should_fail_with_invalid_order_id_length()
    {
        $string = Faker::getInstance()->asciify(
            str_repeat('*', $this->orderIdMaxLength + 1)
        );

        $this->shouldThrow(InvalidArgument::class)->during('setOrderId', [$string]);
    }
}

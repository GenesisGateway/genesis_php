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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace spec\Genesis\API\Traits\Request\Financial\Cards\Recurring;

use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\AmountTypes;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Frequencies;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Intervals;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Modes;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\PaymentTypes;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Cards\Recurring\ManagedRecurringAttributesStub;
use spec\SharedExamples\Faker;

class ManagedRecurringAttributesSpec extends ObjectBehavior
{
    const INVALID_VALUE = 'invalid';

    public function let()
    {
        $this->beAnInstanceOf(ManagedRecurringAttributesStub::class);
    }

    public function it_should_have_proper_structure()
    {
        $this->setAmountRequestParameters('setManagedRecurringAmount');

        $this->requiredManagedRecurringFieldsConditional()->shouldBeArray();
        $this->getManagedRecurringAttributesStructure()->shouldBeArray();
    }

    public function it_should_return_proper_amount()
    {
        $this->setAmountRequestParameters('setManagedRecurringAmount');

        $this->getDocument()->shouldContain(
            "<payment_transaction>" .
            "\n\x20\x20<currency>EUR</currency>" .
            "\n\x20\x20<managed_recurring>" .
            "\n\x20\x20\x20\x20<amount>500</amount>" .
            "\n\x20\x20</managed_recurring>" .
            "\n</payment_transaction>"
        );
    }

    public function it_should_return_proper_max_amount()
    {
        $this->setAmountRequestParameters('setManagedRecurringMaxAmount');

        $this->getDocument()->shouldContain(
            "<payment_transaction>" .
            "\n\x20\x20<currency>EUR</currency>" .
            "\n\x20\x20<managed_recurring>" .
            "\n\x20\x20\x20\x20<max_amount>500</max_amount>" .
            "\n\x20\x20</managed_recurring>" .
            "\n</payment_transaction>"
        );
    }

    public function it_should_throw_with_invalid_mode()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setManagedRecurringMode', [self::INVALID_VALUE]);
    }

    public function it_should_not_throw_with_valid_mode()
    {
        $this->shouldNotThrow()->during(
            'setManagedRecurringMode',
            [Faker::getInstance()->randomElement(Modes::getAll())]
        );
    }

    public function it_should_throw_with_invalid_interval()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setManagedRecurringInterval', [self::INVALID_VALUE]);
    }

    public function it_should_not_throw_with_valid_interval()
    {
        $this->shouldNotThrow()->during(
            'setManagedRecurringInterval',
            [Faker::getInstance()->randomElement(Intervals::getAll())]
        );
    }

    public function it_should_throw_with_invalid_payment_type()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setManagedRecurringPaymentType', [self::INVALID_VALUE]);
    }

    public function it_should_not_throw_with_valid_payment_type()
    {
        $this->shouldNotThrow()->during(
            'setManagedRecurringPaymentType',
            [Faker::getInstance()->randomElement(PaymentTypes::getAll())]
        );
    }

    public function it_should_throw_with_invalid_amount_type()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setManagedRecurringAmountType', [self::INVALID_VALUE]);
    }

    public function it_should_not_throw_with_valid_amount_type()
    {
        $this->shouldNotThrow()->during(
            'setManagedRecurringAmountType',
            [Faker::getInstance()->randomElement(AmountTypes::getAll())]
        );
    }

    public function it_should_throw_with_invalid_frequency()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setManagedRecurringFrequency', [self::INVALID_VALUE]);
    }

    public function it_should_not_throw_with_valid_frequency()
    {
        $this->shouldNotThrow()->during(
            'setManagedRecurringFrequency',
            [Faker::getInstance()->randomElement(Frequencies::getAll())]
        );
    }

    public function it_should_contain_false_string_validated_value()
    {
        $this->setManagedRecurringValidated('no');

        $this->getDocument()->shouldContain(
            "<payment_transaction>" .
            "\n\x20\x20<managed_recurring>" .
            "\n\x20\x20\x20\x20<validated>false</validated>" .
            "\n\x20\x20</managed_recurring>" .
            "\n</payment_transaction>"
        );
    }

    public function it_should_contain_true_string_validated_value()
    {
        $this->setManagedRecurringValidated('true');

        $this->getDocument()->shouldContain(
            "<payment_transaction>" .
            "\n\x20\x20<managed_recurring>" .
            "\n\x20\x20\x20\x20<validated>true</validated>" .
            "\n\x20\x20</managed_recurring>" .
            "\n</payment_transaction>"
        );
    }

    private function setAmountRequestParameters($accessor)
    {
        $this->$accessor('5.00');
        $this->setCurrency('EUR');
    }

    public function it_should_fail_with_invalid_amount()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setManagedRecurringAmount', [-23]);
        $this->shouldThrow(InvalidArgument::class)->during('setManagedRecurringAmount', ['abc']);
    }
}

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

namespace spec\Genesis\API\Traits\Request\Financial\Cards\Recurring;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Cards\Recurring\ManagedRecurringAttributesStub;

class ManagedRecurringAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ManagedRecurringAttributesStub::class);
    }

    public function it_should_have_proper_structure()
    {
        $this->setRequestParameters();

        $this->requiredManagedRecurringFieldsConditional()->shouldBeArray();
        $this->getManagedRecurringAttributesStructure()->shouldBeArray();
    }

    public function it_should_return_proper_amount()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain(
            "<payment_transaction>" .
            "\n\x20\x20<currency>EUR</currency>" .
            "\n\x20\x20<managed_recurring>" .
            "\n\x20\x20\x20\x20<amount>500</amount>" .
            "\n\x20\x20</managed_recurring>" .
            "\n</payment_transaction>"
        );
    }

    public function setRequestParameters()
    {
        $this->setManagedRecurringAmount('5.00');
        $this->setCurrency('EUR');
    }
}

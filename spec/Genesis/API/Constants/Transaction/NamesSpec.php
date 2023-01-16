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

namespace spec\Genesis\API\Constants\Transaction;

use Genesis\API\Constants\Transaction\Names;
use Genesis\API\Constants\Transaction\Types;
use PhpSpec\ObjectBehavior;

class NamesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Names::class);
    }

    public function it_should_return_array_with_all_transaction_names()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_with_transaction_names()
    {
        $this->getAll()->shouldNotBeEqualTo([]);
    }

    public function it_should_return_string_for_transaction_name()
    {
        foreach(Types::getAll() as $transactionType)
        $this->getName($transactionType)->shouldBeString();
    }

    public function it_should_return_corrent_name_for_every_defined_transaction_type()
    {
        foreach(Types::getAll() as $transactionType) {
            $this->getName($transactionType)->shouldNotBe('Unknown Transaction Type');
        }
    }

    public function it_should_return_correct_name_for_wpf_transaction_types()
    {
        foreach(Types::getWPFTransactionTypes() as $transactionType) {
            $this->getName($transactionType)->shouldNotBe('Unknown Transaction Types');
        }
    }

    public function it_should_return_specific_string_for_invalid_transcation_type()
    {
        $this->getName('invalid_trx_type')->shouldBe('Unknown Transaction Type');
    }

    public function it_should_not_throw_during_get_name_with_invalid_transaction_type()
    {
        $this->shouldNotThrow()->during('getName', ['invalid_trx_type']);
    }
}

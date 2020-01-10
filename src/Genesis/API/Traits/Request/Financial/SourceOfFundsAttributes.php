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

namespace Genesis\API\Traits\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\SourceOfFunds;
use Genesis\Utils\Common;

/**
 * Trait SourceOfFundsAttrubutes
 * @package Genesis\API\Traits\Request\Financial
 */
trait SourceOfFundsAttributes
{
    /**
     * Specify the source of funds
     *
     * @var $source_of_funds
     */
    protected $source_of_funds;

    /**
     * Source of Funds Setter
     *
     * @param $value
     * @return $this
     */
    public function setSourceOfFunds($value)
    {
        if ($value === null) {
            $this->source_of_funds = null;

            return $this;
        }

        $this->allowedOptionsSetter(
            'source_of_funds',
            SourceOfFunds::getAll(),
            $value,
            'Invalid value for source_of_funds parameter.'
        );

        return $this;
    }

    /**
     * Source of Funds Request parameter structure
     *
     * @return array
     */
    protected function getSourceOfFundsStructure()
    {
        return [
            'source_of_funds' => $this->source_of_funds
        ];
    }
}

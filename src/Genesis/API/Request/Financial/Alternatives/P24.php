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

namespace Genesis\API\Request\Financial\Alternatives;

/**
 * Class P24
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives
 */
class P24 extends \Genesis\API\Request\Base\Financial\Alternative
{
    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::P24;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        parent::setRequiredFields();

        $requiredFieldValues = [
            'billing_country' => [
                'AD', 'AT', 'BE', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'EL', 'ES', 'NL',
                'IE', 'IS', 'LT', 'LV', 'LU', 'MT', 'DE', 'NO', 'PL', 'PT', 'SM', 'SK',
                'SI', 'CH', 'SE', 'HU', 'GB', 'IT', 'US', 'CA', 'JP', 'UA', 'BY', 'RU'
            ],
            'currency'        => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }
}

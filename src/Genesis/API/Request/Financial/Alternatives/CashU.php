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
 * Class CashU
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives
 */
class CashU extends \Genesis\API\Request\Base\Financial\Alternative
{
    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::CASHU;
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
                'DZ', 'BH', 'EG', 'GM', 'GH', 'IN', 'IR', 'IQ', 'IL', 'JO', 'KE',
                'KR', 'KW', 'LB', 'LY', 'MY', 'MR', 'MA', 'NG', 'OM', 'PK', 'PS',
                'QA', 'SA', 'SL', 'SD', 'SY', 'TZ', 'TN', 'TR', 'AE', 'US', 'YE'
            ],
            'currency'        => [
                'USD', 'AED', 'EUR', 'JOD', 'EGP', 'SAR', 'DZD', 'LBP', 'MAD', 'QAR', 'TRY'
            ]
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }
}

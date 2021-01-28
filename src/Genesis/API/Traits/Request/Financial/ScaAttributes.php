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

use Genesis\API\Constants\Transaction\Parameters\ScaExemptions;
use Genesis\Exceptions\ErrorParameter;

/**
 * Trait ScaAttributes
 * @package Genesis\API\Traits\Request\Financial
 *
 * @method setScaVisaMerchantId($value) VMID assigned by Visa if participating in Trusted merchant program.
 */
trait ScaAttributes
{
    /**
     * The exemption that the transaction should take advantage of.
     *
     * @var $exemption
     */
    protected $sca_exemption;

    /**
     * VMID assigned by Visa if participating in Trusted merchant program.
     *
     * @var $visa_merchant_id
     */
    protected $sca_visa_merchant_id;

    /**
     * Validate Exemption param
     *
     * @param $value
     * @return $this
     * @throws ErrorParameter
     */
    public function setScaExemption($value)
    {
        $scaExemptions = ScaExemptions::getAll();

        if (!in_array($value, $scaExemptions)) {
            throw new ErrorParameter(
                sprintf(
                    'Parameter Sca Exemption not valid! Use one of the following %s',
                    implode(', ', $scaExemptions)
                )
            );
        }

        $this->sca_exemption = $value;

        return $this;
    }

    protected function getScaAttributesStructure()
    {
        return [
            'sca_params' => [
                'exemption'        => $this->sca_exemption,
                'visa_merchant_id' => $this->sca_visa_merchant_id
            ]
        ];
    }
}

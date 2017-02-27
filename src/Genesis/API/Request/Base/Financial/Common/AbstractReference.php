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
namespace Genesis\API\Request\Base\Financial\Common;

/**
 * Class AbstractReference
 *
 * Base Abstract Class for Reference Transactions (Capture, Refund, Credit & Recurring)
 *
 * @package Genesis\API\Request\Base\Financial\Common
 *
 * @method $this setAmount($value) Set the Amount of transaction in minor currency unit
 * @method $this setCurrency($value) Set the currency code in ISO-4217
 * @method $this setReferenceId($value) Set Unique id of the existing (target) transaction
 */
abstract class AbstractReference extends \Genesis\API\Request\Base\Financial\AbstractBase
{
    /**
     * Amount of transaction in minor currency unit
     *
     * @var int|float|double
     */
    protected $amount;

    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

    /**
     * Unique id of the existing (target) transaction
     *
     * @var string
     */
    protected $reference_id;

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = array(
            'transaction_id',
            'reference_id',
            'amount',
            'currency'
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getRequestTreeStructure()
    {
        return array(
            'reference_id'     => $this->reference_id,
            'amount'           => $this->transform(
                'amount',
                array(
                    $this->amount,
                    $this->currency,
                )
            ),
            'currency'         => $this->currency
        );
    }
}

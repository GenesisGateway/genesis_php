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
namespace Genesis\API\Request\Base\Financial\Cards\Synchronous;

/**
 * Class ASale
 *
 * Abstract Base Class for Synchronous Sale Transactions
 *
 * @package Genesis\API\Request\Base\Financial\Cards\Synchronous
 *
 * @method $this setGaming($value) Signifies whether a gaming transaction is performed.
 * @method $this setMoto($value) Signifies whether a MOTO (mail order telephone order) transaction is performed.
 * @method $this setDynamicMerchantName($value) Dynamically override the charge descriptor
 * @method $this setDynamicMerchantCity($value) Dynamically override the merchant phone number
 */
abstract class ASale extends \Genesis\API\Request\Base\Financial\Cards\Synchronous\AbstractTransaction
{
    /**
     * Signifies whether a gaming transaction is performed.
     *
     * Gaming transactions usually use MCC 7995, contact tech support for more details.
     *
     * @var bool
     */
    protected $gaming;

    /**
     * Signifies whether a MOTO (mail order telephone order) transaction is performed.
     *
     * Contact tech support for more details.
     *
     * @var bool
     */
    protected $moto;

    /**
     * Allows to dynamically override the charge descriptor
     *
     * @var string
     */
    protected $dynamic_merchant_name;

    /**
     * Allows to dynamically override the mer- chant phone number
     *
     * @var string
     */
    protected $dynamic_merchant_city;

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = array(
            'transaction_id',
            'amount',
            'currency',
            'card_holder',
            'expiration_month',
            'expiration_year',
            'card_number',
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getRequestTreeStructure()
    {
        $treeStructure = parent::getRequestTreeStructure();

        return array_merge(
            $treeStructure,
            array(
                'gaming'                    => $this->gaming,
                'moto'                      => $this->moto,
                'dynamic_descriptor_params' => array(
                    'merchant_name' => $this->dynamic_merchant_name,
                    'merchant_city' => $this->dynamic_merchant_city
                )
            )
        );
    }
}

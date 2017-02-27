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
namespace Genesis\API\Request\Financial\PayByVouchers;

/**
 * Class Sale
 *
 * PayByVoucher purchase via Debit/Credit Sale
 *
 * @package Genesis\API\Request\Financial\PayByVouchers
 *
 * @method Sale setDynamicMerchantName($value) Dynamically override the charge descriptor
 * @method Sale setDynamicMerchantCity($value) Dynamically override the merchant phone number
 */
class Sale extends \Genesis\API\Request\Base\Financial\PayByVouchers\ASale
{
    /**
     * Allows to dynamically override the charge descriptor
     *
     * @var string
     */
    protected $dynamic_merchant_name;

    /**
     * Allows to dynamically override the merchant phone number
     *
     * @var string
     */
    protected $dynamic_merchant_city;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::PAYBYVOUCHER_SALE;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = array(
            'transaction_id',
            'card_type',
            'redeem_type',
            'amount',
            'currency',
            'card_holder',
            'card_number',
            'expiration_month',
            'expiration_year',
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
                'dynamic_descriptor_params' => array(
                    'merchant_name' => $this->dynamic_merchant_name,
                    'merchant_city' => $this->dynamic_merchant_city,
                )
            )
        );
    }
}

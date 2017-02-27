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
namespace Genesis\API\Request\Financial\Wallets;

/**
 * Class WebMoney
 *
 * Electronic Wallet
 *
 * @package Genesis\API\Request\Financial\Wallets
 *
 * @method WebMoney setCustomerAccountId($value) Set Webmoney account ID (WMID)
 */
class WebMoney extends \Genesis\API\Request\Base\Financial\Wallets\Asynchronous\AbstractTransaction
{
    /**
     * Flag for payout transaction
     *
     * @var bool
     */
    protected $is_payout;

    /**
     * Webmoney account ID (WMID)
     *
     * @var string
     */
    protected $customer_account_id;

    /**
     * WebMoney constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setIsPayout(false);
    }

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::WEBMONEY;
    }

    /**
     * Set Flag for payout transaction
     * @param bool|int|string $value
     * @return $this
     */
    public function setIsPayout($value)
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        $this->is_payout = ($value ? 'true' : 'false');

        return $this;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        parent::setRequiredFields();

        $requiredFieldsConditional = array(
            'is_payout'   => array(
                'true' => array(
                    'customer_account_id'
                )
            ),
        );

        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);
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
                'is_payout'           => $this->is_payout,
                'customer_account_id' => $this->customer_account_id
            )
        );
    }
}

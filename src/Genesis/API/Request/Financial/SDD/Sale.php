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
namespace Genesis\API\Request\Financial\SDD;

/**
 * Class Sale
 *
 * SDD Payment Transactions
 *
 * @package Genesis\API\Request\Financial\SDD
 *
 * @method $this setIban($value) Set a valid IBAN bank account
 * @method $this setBic($value) Set a valid BIC code
 * @method $this setBillingFirstName($value) Set the customer's First name
 * @method $this setBillingLastName($value) Set the customer's Last name
 */
class Sale extends \Genesis\API\Request\Base\Financial\Common\Risk\Async\AbstractBase
{
    /**
     * Must contain valid IBAN, check
     * in the official API documentation
     *
     * @var string
     */
    protected $iban;

    /**
     * Must contain valid BIC, check
     * in the official API documentation
     *
     * @var string
     */
    protected $bic;

    /**
     * Customer's First name
     *
     * @var string
     */
    protected $billing_first_name;

    /**
     * Customer's Last name
     *
     * @var string
     */
    protected $billing_last_name;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::SDD_SALE;
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
                'iban'              => $this->iban,
                'bic'               => $this->bic,
                'billing_address' => array(
                    'first_name'    => $this->billing_first_name,
                    'last_name'     => $this->billing_last_name
                )
            )
        );
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
            'usage',
            'amount',
            'currency',
            'iban',
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }
}

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
 * Class AbstractTransaction
 *
 * Abstract Base Class for Financial Card Synchronous Payment Transactions
 *
 * @package Genesis\API\Request\Base\Financial\Cards\Synchronous
 *
 * @method $this setCardHolder($value) Set Full name of customer as printed on credit card
 * @method $this setCardNumber($value) Set Complete CC number of customer
 * @method $this setCvv($value) Set CVV of CC, requirement is based on terminal configuration
 * @method $this setExpirationMonth($value) Set Expiration month as printed on credit card
 * @method $this setExpirationYear($value) Set Expiration year as printed on credit card
 * @method $this setBirthDate($value) Set Birth date of the customer
 */
abstract class AbstractTransaction extends \Genesis\API\Request\Base\Financial\Common\Risk\AbstractBaseCustomerInfo
{
    /**
     * Full name of customer as printed on credit card (first name and last name at least)
     *
     * @var string
     */
    protected $card_holder;

    /**
     * Complete CC number of customer
     *
     * @var int
     */
    protected $card_number;

    /**
     * CVV of CC, requirement is based on terminal configuration
     *
     * @var int
     */
    protected $cvv;

    /**
     * Expiration month as printed on credit card
     *
     * @var string (mm)
     */
    protected $expiration_month;

    /**
     * Expiration year as printed on credit card
     *
     * @var string (yyyy)
     */
    protected $expiration_year;

    /**
     * Birth date of the customer
     *
     * @var string
     */
    protected $birth_date;

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
                'card_holder'      => $this->card_holder,
                'card_number'      => $this->card_number,
                'cvv'              => $this->cvv,
                'expiration_month' => $this->expiration_month,
                'expiration_year'  => $this->expiration_year,
                'birth_date'       => $this->birth_date,
            )
        );
    }
}

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
namespace Genesis\API\Request\Financial;

/**
 * Refund request
 *
 * @package    Genesis
 * @subpackage Request
 */
class Refund extends \Genesis\API\Request
{
    /**
     * Unique transaction id defined by merchant
     *
     * @var string
     */
    protected $transaction_id;

    /**
     * Description of the transaction for later use
     *
     * @var string
     */
    protected $usage;

    /**
     * IPv4 address of customer
     *
     * @var string
     */
    protected $remote_ip;

    /**
     * Amount of transaction in minor currency unit
     *
     * @var int
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
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->config = \Genesis\Utils\Common::createArrayObject(
            array(
                'protocol' => 'https',
                'port'     => 443,
                'type'     => 'POST',
                'format'   => 'xml',
            )
        );

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'process', \Genesis\Config::getToken()));
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
            'reference_id',
            'amount',
            'currency'
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = array(
            'payment_transaction' => array(
                'transaction_type' => \Genesis\API\Constants\Transaction\Types::REFUND,
                'transaction_id'   => $this->transaction_id,
                'usage'            => $this->usage,
                'remote_ip'        => $this->remote_ip,
                'reference_id'     => $this->reference_id,
                'amount'           => $this->transform(
                    'amount',
                    array(
                        $this->amount,
                        $this->currency,
                    )
                ),
                'currency'         => $this->currency
            )
        );

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

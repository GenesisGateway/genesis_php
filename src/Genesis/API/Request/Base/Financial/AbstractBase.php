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
namespace Genesis\API\Request\Base\Financial;

/**
 * Class AbstractBase
 *
 * Base Abstract Class for all Financial Requests
 *
 * @package Genesis\API\Request\Base\Financial
 *
 * @method $this setTransactionId($value) Set a Unique Transaction id
 * @method $this setUsage($value) Set the description of the transaction for later use
 * @method $this setRemoteIp($value) Set the IPv4 address of customer
 */
abstract class AbstractBase extends \Genesis\API\Request
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
     * Returns the Request transaction type
     * @return string
     */
    abstract protected function getTransactionType();

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getRequestTreeStructure()
    {
        return array(

        );
    }

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

        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                'gateway',
                'process',
                \Genesis\Config::getToken()
            )
        );
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
                'transaction_type'          => $this->getTransactionType(),
                'transaction_id'            => $this->transaction_id,
                'usage'                     => $this->usage,
                'remote_ip'                 => $this->remote_ip
            )
        );

        $treeStructure['payment_transaction'] += $this->getRequestTreeStructure();

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

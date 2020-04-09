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

namespace Genesis\API\Request\Base;

use Genesis\API\Traits\Request\BaseAttributes;
use Genesis\API\Validators\Request\Base\Validator as RequestValidator;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Financial
 *
 * Base Abstract Class for all Financial Requests
 *
 * @package Genesis\API\Request\Base
 */
abstract class Financial extends \Genesis\API\Request
{
    use BaseAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    abstract protected function getTransactionType();

    /**
     * Return additional request attributes
     * @return array
     */
    abstract protected function getPaymentTransactionStructure();

    /**
     * Initialize per-request configuration
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration();
    }

    /**
     * Perform field validation
     *
     * @return void
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateConditionalValuesRequirements();
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'payment_transaction' => [
                'transaction_type' => $this->getTransactionType(),
                'transaction_id'   => $this->transaction_id,
                'usage'            => $this->usage,
                'remote_ip'        => $this->remote_ip
            ]
        ];

        $treeStructure['payment_transaction'] += $this->getPaymentTransactionStructure();

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

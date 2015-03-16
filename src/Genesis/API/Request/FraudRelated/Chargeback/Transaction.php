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
namespace Genesis\API\Request\FraudRelated\Chargeback;

/**
 * Chargeback request by ARN/Unique Transaction Id
 *
 * @package    Genesis
 * @subpackage Request
 */
class Transaction extends \Genesis\API\Request
{
    protected $arn;
    protected $original_transaction_unique_id;

    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'chargebacks', false));
    }

    private function initConfiguration()
    {
        $config = array(
            'url' => '',
            'port' => 443,
            'type' => 'POST',
            'format' => 'xml',
            'protocol' => 'https',
        );

        $this->config = \Genesis\Utils\Common::createArrayObject($config);
    }

    private function setRequiredFields()
    {
        $requiredFieldsOR = array(
            'arn',
            'original_transaction_unique_id'
        );

        $this->requiredFieldsOR = \Genesis\Utils\Common::createArrayObject($requiredFieldsOR);
    }

    protected function populateStructure()
    {
        $treeStructure = array(
            'chargeback_request' => array(
                'arn' => $this->arn,
                'original_transaction_unique_id' => $this->original_transaction_unique_id,
            )
        );

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

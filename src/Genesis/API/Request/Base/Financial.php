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
     * Store the names of "conditionally" Required fields with expected values.
     *
     * @var \ArrayObject
     */
    protected $requiredFieldValuesConditional;

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
     * @throws \Genesis\Exceptions\ErrorParameter
     * @return void
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->verifyConditionalValuesRequirements();
    }

    /**
     * Verify that all fields (who depend on previously populated fields)
     * are populated with expected values
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function verifyConditionalValuesRequirements()
    {
        if (!isset($this->requiredFieldValuesConditional)) {
            return;
        }

        $fields = $this->requiredFieldValuesConditional->getArrayCopy();

        foreach ($fields as $parentFieldName => $parentFieldDependencies) {
            if (!isset($this->$parentFieldName)) {
                continue;
            }

            foreach ($parentFieldDependencies as $parentFieldValue => $childFieldsDependency) {
                if ($this->$parentFieldName !== $parentFieldValue) {
                    continue;
                }

                $childFieldGroupValuesValidated = false;

                foreach ($childFieldsDependency as $childFieldDependency) {
                    $childFieldValuesValidated = true;

                    foreach ($childFieldDependency as $childFieldName => $childFieldValues) {
                        if ($childFieldValues instanceof RequestValidator) {
                            try {
                                $childFieldValues->run($this, $childFieldName);
                            } catch (\Genesis\Exceptions\InvalidArgument $e) {
                                $childFieldValuesValidated = false;
                            }

                            continue;
                        }

                        if (CommonUtils::isValidArray($childFieldValues)) {
                            if (!in_array($this->$childFieldName, $childFieldValues)) {
                                $childFieldValuesValidated = false;
                            }

                            continue;
                        }

                        if ($this->$childFieldName !== $childFieldValues) {
                            $childFieldValuesValidated = false;
                        }
                    }

                    if ($childFieldValuesValidated) {
                        $childFieldGroupValuesValidated = true;

                        break;
                    }
                }

                if (!$childFieldGroupValuesValidated) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf(
                            '%s with value %s is depending on group of params with specific values. ' .
                            'Please, refer to the official API documentation for %s transaction type.',
                            $parentFieldName,
                            $parentFieldValue,
                            $this->getTransactionType()
                        )
                    );
                }
            }
        }
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

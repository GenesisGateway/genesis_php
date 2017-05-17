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
namespace Genesis\API\Request\WPF;

use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\NotificationAttributes;
use Genesis\API\Traits\Request\RiskAttributes;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Web-Payment-Form Request
 *
 * @package    Genesis
 * @subpackage Request
 *
 * @method $this setTransactionId($value) Set a Unique Transaction id
 * @method $this setUsage($value) Set the description of the transaction for later use
 * @method $this setDescription($value) Set a text describing the reason of the payment

 * @method $this setReturnCancelUrl($value) Set the  URL where the customer is sent to after they cancel the payment
 */
class Create extends \Genesis\API\Request
{
    use PaymentAttributes, AddressInfoAttributes, AsyncAttributes,
        NotificationAttributes, RiskAttributes, DescriptorAttributes;

    /**
     * unique transaction id defined by merchant
     *
     * @var string
     */
    protected $transaction_id;

    /**
     * Statement, as it appears in the customer’s bank statement
     *
     * @var string
     */
    protected $usage;

    /**
     * a text describing the reason of the payment
     *
     * e.g. "you’re buying concert tickets"
     *
     * @var string
     */
    protected $description;

    /**
     * URL where the customer is sent to after they cancel the payment
     *
     * @var string
     */
    protected $return_cancel_url;

    /**
     * The transaction types that the merchant is willing to accept payments for
     *
     * @var array
     */
    protected $transaction_types = [];

    /**
     * Add transaction type to the list of available types
     *
     * @param string $name
     *
     * @param array  $parameters
     *
     * @return $this
     */
    public function addTransactionType($name, $parameters = [])
    {
        $this->verifyTransactionType($name, $parameters);

        $structure = [
            'transaction_type' => [
                '@attributes' => [
                    'name' => $name
                ],
                $parameters
            ]
        ];

        array_push($this->transaction_types, $structure);

        return $this;
    }

    /**
     * Verify that transaction type parameters are populated correctly
     *
     * @param string $transactionType
     * @param array $parameters
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyTransactionType($transactionType, $parameters = [])
    {
        if (!\Genesis\API\Constants\Transaction\Types::isValidTransactionType($transactionType)) {
            throw new \Genesis\Exceptions\ErrorParameter(
                sprintf(
                    'Transaction type (%s) is not valid',
                    $transactionType
                )
            );
        }

        $txnCustomRequiredParams = \Genesis\API\Constants\Transaction\Types::getCustomRequiredParameters(
            $transactionType
        );

        if (!CommonUtils::isValidArray($txnCustomRequiredParams)) {
            return;
        }

        foreach ($txnCustomRequiredParams as $customRequiredParam => $customRequiredParamValues) {
            $this->checkEmptyRequiredParamsFor($transactionType, $customRequiredParam, $parameters);

            if (!CommonUtils::isValidArray($customRequiredParamValues)) {
                continue;
            }

            if (!CommonUtils::arrayContainsArrayItems($parameters)) {
                if (!in_array($parameters[$customRequiredParam], $customRequiredParamValues)) {
                    sprintf(
                        'Invalid value (%s) for required parameter: %s (Transaction type: %s)',
                        $parameters[$customRequiredParam],
                        $customRequiredParam,
                        $transactionType
                    );
                }

                continue;
            }

            foreach ($parameters as $parameter) {
                if (!in_array($parameter[$customRequiredParam], $customRequiredParamValues)) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf(
                            'Invalid value (%s) for required parameter: %s (Transaction type: %s)',
                            $parameter[$customRequiredParam],
                            $customRequiredParam,
                            $transactionType
                        )
                    );
                }
            }
        }
    }

    /**
     * Performs a check there is an empty required param for the passed transaction type
     *
     * @param string $transactionType
     * @param string $customRequiredParam
     * @param array $txnParameters
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function checkEmptyRequiredParamsFor($transactionType, $customRequiredParam, $txnParameters = [])
    {
        if (CommonUtils::isArrayKeyExists($customRequiredParam, $txnParameters)) {
            return;
        }

        foreach ($txnParameters as $parameter) {
            if (!CommonUtils::isArrayKeyExists($customRequiredParam, $parameter)) {
                throw new \Genesis\Exceptions\ErrorParameter(
                    sprintf(
                        'Empty (null) required parameter: %s for transaction type %s',
                        $customRequiredParam,
                        $transactionType
                    )
                );
            }
        }
    }

    /**
     * Add ISO 639-1 language code to the URL
     *
     * @param string $language iso code of the language
     *
     * @return $this
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setLanguage($language = \Genesis\API\Constants\i18n::EN)
    {
        // Strip the input down to two letters
        $language = substr(strtolower($language), 0, 2);

        if (!\Genesis\API\Constants\i18n::isValidLanguageCode($language)) {
            throw new \Genesis\Exceptions\InvalidArgument(
                'The provided argument is not a valid ISO-639-1 language code!'
            );
        }

        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                'wpf',
                sprintf('%s/wpf', $language),
                false
            )
        );

        return $this;
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->setApiConfig('url', $this->buildRequestURL('wpf', 'wpf', false));
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'amount',
            'currency',
            'description',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'return_cancel_url',
            'transaction_types'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'wpf_payment' => [
                'transaction_id'            => $this->transaction_id,
                'amount'                    => $this->transform(
                    'amount',
                    [
                        $this->amount,
                        $this->currency
                    ]
                ),
                'currency'                  => $this->currency,
                'usage'                     => $this->usage,
                'description'               => $this->description,
                'customer_email'            => $this->customer_email,
                'customer_phone'            => $this->customer_phone,
                'notification_url'          => $this->notification_url,
                'return_success_url'        => $this->return_success_url,
                'return_failure_url'        => $this->return_failure_url,
                'return_cancel_url'         => $this->return_cancel_url,
                'billing_address'           => $this->getBillingAddressParamsStructure(),
                'shipping_address'          => $this->getShippingAddressParamsStructure(),
                'transaction_types'         => $this->transaction_types,
                'risk_params'               => $this->getRiskParamsStructure(),
                'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure()
            ]
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}

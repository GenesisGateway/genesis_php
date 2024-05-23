<?php

/**
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
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Financial\Cards\Threeds\V2;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Request;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\DeprecatedMethod;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidMethod;
use Genesis\Genesis;
use Genesis\Utils\Common;
use Genesis\Utils\Currency;
use Genesis\Utils\Threeds\V2 as ThreedsV2Utils;

/**
 * Class MethodContinue
 * @package Genesis\Api\Request\Financial\Cards\Threeds\V2
 *
 * @codingStandardsIgnoreStart
 * @method $this  setSignature($value) SHA512 of а concatenated string (unique_id, amount, timestamp, merchant_api_password)
 * @method $this  setTransactionUniqueId($value)  Equivalent to the value of the unique_id, received from the response of the initial transaction request
 * @codingStandardsIgnoreEnd
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MethodContinue extends Request
{
    use PaymentAttributes;

    /**
     * A link between the customer's browser and the card issuer must be opened with a hidden iframe
     *
     * @var string $url
     */
    protected $url;

    /**
     * Equivalent to the value of the unique_id, received from the response of the initial transaction request
     *
     * @var string $transaction_unique_id
     */
    protected $transaction_unique_id;

    /**
     * SHA512 of а concatenated string (unique_id, amount, timestamp, merchant_api_password)
     * unique_id, amount, timestamp can be taken from the response of the initial transaction request
     * and merchant_api_password is the password used for HTTP Basic authentication to the API
     * during the initial transaction request
     *
     * @var string $signature
     */
    protected $signature;

    /**
     * The timestamp from the initial transaction response
     *
     * @var \DateTime $transaction_timestamp
     */
    protected $transaction_timestamp;

    /**
     * ThreedsV2Continue constructor.
     * Initialize the FORM Builder
     */
    public function __construct()
    {
        parent::__construct(Builder::FORM);
    }

    /**
     * Configures a Secure PUT Request with Form body
     *
     * @return void
     * @throws \Genesis\Exceptions\EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        $this->initFormConfiguration();
        $this->config->offsetSet('type', self::METHOD_PUT);

        $this->setApiConfig(
            'url',
            $this->buildRequestURL('gateway', 'threeds/threeds_method/:unique_id', false)
        );
    }

    /**
     * Fill the :unique_id in the endpoint URL after the checks
     *
     * @throws InvalidArgument
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function processRequestParameters()
    {
        $this->configureEndpointUrl($this->getUrl());

        parent::processRequestParameters();
    }

    /**
     * A link between the customer's browser and the card issuer must be opened with a hidden iframe
     *
     * @return string
     */
    public function getUrl()
    {
        if (empty($this->url)) {
            return $this->generateEndpointUrl();
        }

        return $this->url;
    }

    /**
     * A link between the customer's browser and the card issuer must be opened with a hidden iframe
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setUrl($value)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_URL);

        if ($filteredValue === false) {
            throw new InvalidArgument('Invalid url is given.');
        }

        $this->url = $filteredValue;

        return $this;
    }

    /**
     * Equivalent to the value of the unique_id, received from the response of the initial transaction request
     *
     * @return string|null
     */
    public function getTransactionUniqueId()
    {
        if (empty($this->transaction_unique_id)) {
            return $this->extractUniqueIdFromUrl($this->url);
        }

        return $this->transaction_unique_id;
    }

    /**
     * The timestamp from the initial transaction response
     *
     * @return string|null
     */
    public function getTransactionTimestamp()
    {
        if (empty($this->transaction_timestamp)) {
            return null;
        }

        return $this->transaction_timestamp->format(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU);
    }

    /**
     * The timestamp from the initial transaction response
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setTransactionTimestamp($value)
    {
        return $this->parseDate(
            'transaction_timestamp',
            [DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU],
            $value,
            'Invalid timestamp format.'
        );
    }

    /**
     * SHA512 of а concatenated string (unique_id, amount, timestamp, merchant_api_password)
     *
     * @return string
     */
    public function getSignature()
    {
        if (empty($this->signature)) {
            $amount = !empty($this->currency) ? $this->transformAmount($this->amount, $this->currency) : $this->amount;

            return ThreedsV2Utils::generateSignature(
                $this->getTransactionUniqueId(),
                $amount,
                $this->getTransactionTimestamp(),
                Config::getPassword()
            );
        }

        return $this->signature;
    }

    /**
     * Identify the Currency of the Transaction
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setCurrency($value)
    {
        if (empty($value)) {
            $this->currency = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'currency',
            Currency::getList(),
            $value,
            'Invalid value given for currency parameter.'
        );
    }

    /**
     * Define the required fields for the transaction
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'amount',
            'transaction_timestamp'
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldsOr = [
            'url',
            'transaction_unique_id'
        ];

        $this->requiredFieldsOR = Common::createArrayObject($requiredFieldsOr);
    }


    /**
     * The Request params structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $this->treeStructure = Common::createArrayObject(
            [
                'unique_id' => $this->getTransactionUniqueId(),
                'signature' => $this->getSignature()
            ]
        );
    }

    /**
     * Extract the Unique Id
     *
     * @param string $url
     * @return string|null
     */
    private function extractUniqueIdFromUrl($url)
    {
        $urlPath = parse_url((string)$url, PHP_URL_PATH);

        if ($urlPath === false) {
            return null;
        }

        $urlComponents = explode('/', $urlPath);

        return end($urlComponents);
    }

    /**
     * Fills the Unique Id in the endpoint URL
     *
     * @return string
     */
    private function generateEndpointUrl()
    {
        return str_replace(':unique_id', (string)$this->getTransactionUniqueId(), $this->getApiConfig('url'));
    }

    /**
     * Set the endpoint Url in the config
     *
     * @param $endpointUrl
     * @return void
     */
    private function configureEndpointUrl($endpointUrl)
    {
        $this->setApiConfig(
            'url',
            $endpointUrl
        );
    }

    /**
     * Loads the Request from the initial transaction response
     *
     * @param \stdClass $responseObject
     *
     * @return Genesis
     *
     * @throws InvalidArgument
     * @throws DeprecatedMethod
     * @throws InvalidMethod
     * @throws ErrorParameter
     */
    public static function buildFromResponseObject(\stdClass $responseObject)
    {
        if (
            !isset($responseObject->threeds_method_continue_url)
            || !isset($responseObject->unique_id)
            || !isset($responseObject->amount) || !isset($responseObject->currency)
            || !isset($responseObject->timestamp) || !($responseObject->timestamp instanceof \DateTime)
        ) {
            throw new ErrorParameter('Response object is incomplete or required attributes are missing!');
        }

        $genesis = new Genesis('Financial\Cards\Threeds\V2\MethodContinue');

        /** @var MethodContinue $requestObject */
        $requestObject = $genesis->request();
        $requestObject
            ->setTransactionUniqueId($responseObject->unique_id)
            ->setAmount($responseObject->amount)
            ->setCurrency($responseObject->currency)
            ->setTransactionTimestamp($responseObject->timestamp->format(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU));

        return $genesis;
    }
}

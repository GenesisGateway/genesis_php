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

namespace Genesis\Api\Traits\Request\Wpf;

use Genesis\Api\Constants\Transaction\Types;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Common as CommonUtils;

/**
 * Trait Validations
 * @package Genesis\Api\Traits\Request\Wpf
 */
trait Validations
{
    /**
     * Verify that transaction type parameters are populated correctly
     *
     * @param string $transactionType
     * @param array $parameters
     * @throws ErrorParameter
     */
    protected function verifyTransactionType($transactionType, $parameters = [])
    {
        if (!Types::isValidWPFTransactionType($transactionType)) {
            throw new ErrorParameter(
                sprintf(
                    'Transaction type (%s) is not valid. Valid WPF transactions are: %s.',
                    $transactionType,
                    implode(', ', Types::getWPFTransactionTypes())
                )
            );
        }

        $txnCustomRequiredParams = Types::getCustomRequiredParameters(
            $transactionType
        );

        if (!CommonUtils::isValidArray($txnCustomRequiredParams)) {
            return;
        }

        if (CommonUtils::isValidArray($txnCustomRequiredParams) && !CommonUtils::isValidArray($parameters)) {
            throw new ErrorParameter(
                sprintf(
                    'Custom transaction parameters (%s) are required and none are set.',
                    implode(', ', array_keys($txnCustomRequiredParams))
                )
            );
        }

        foreach ($txnCustomRequiredParams as $customRequiredParam => $customRequiredParamValues) {
            $this->validateRequiredParameter(
                $transactionType,
                $customRequiredParam,
                $customRequiredParamValues,
                $parameters
            );
        }
    }

    protected function validateRequiredParameter(
        $transactionType,
        $customRequiredParam,
        $customRequiredParamValues,
        $parameters
    ) {
        $this->checkEmptyRequiredParamsFor(
            $transactionType,
            $customRequiredParam,
            $parameters
        );

        if (!CommonUtils::isValidArray($customRequiredParamValues)) {
            return;
        }

        if (!CommonUtils::arrayContainsArrayItems($parameters)) {
            $this->checkIsParamSet(
                $transactionType,
                $parameters[$customRequiredParam],
                $customRequiredParamValues,
                $customRequiredParam
            );

            return;
        }

        foreach ($parameters as $parameter) {
            $this->checkIsParamSet(
                $transactionType,
                $parameter,
                $customRequiredParamValues,
                $customRequiredParam
            );
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
    protected function checkEmptyRequiredParamsFor(
        $transactionType,
        $customRequiredParam,
        $txnParameters = []
    ) {
        if (
            CommonUtils::isArrayKeyExists($customRequiredParam, $txnParameters) &&
            !empty($txnParameters[$customRequiredParam])
        ) {
            return;
        }

        foreach ($txnParameters as $parameter) {
            if (
                CommonUtils::isArrayKeyExists($customRequiredParam, $parameter) &&
                !empty($parameter[$customRequiredParam])
            ) {
                return;
            }
        }

        throw new ErrorParameter(
            sprintf(
                'Empty (null) required parameter: %s for transaction type %s',
                $customRequiredParam,
                $transactionType
            )
        );
    }

    /**
     * @param string $transactionType
     * @param array $parameters
     * @param mixed $paramValues
     * @param string $paramName
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    private function checkIsParamSet($transactionType, $parameters, $paramValues, $paramName)
    {
        if (!in_array($parameters, $paramValues)) {
            throw new ErrorParameter(
                sprintf(
                    'Invalid value (%s) for required parameter: %s. Allowed values: %s. (Transaction type: %s)',
                    is_array($parameters) ? implode(', ', $parameters) : $parameters,
                    $paramName,
                    is_array($paramValues) ? implode(', ', $paramValues) : $paramValues,
                    $transactionType
                )
            );
        }
    }
}

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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\MarketplaceData\ForeignRetailerIndicators;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait MarketplaceDataAttributes
 *
 * Visa foreign retailer data (marketplace_data)
 *
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method string|null getForeignRetailerIndicator()
 * @method string|null getForeignRetailerTransactionAmount()
 */
trait MarketplaceDataAttributes
{
    /**
     * Foreign retailer indicator. The only allowed value is F
     *
     * @var string
     */
    protected $foreign_retailer_indicator;

    /**
     * Portion of the transaction amount attributed to foreign retailers,
     * in major currency units of the request currency
     *
     * @var string
     */
    protected $foreign_retailer_transaction_amount;

    /**
     * Validate and set foreign_retailer_indicator param. Null clears the value
     *
     * @param string|null $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setForeignRetailerIndicator($value)
    {
        if ($value === null) {
            $this->foreign_retailer_indicator = null;

            return $this;
        }

        $allowed = ForeignRetailerIndicators::getAll();
        $message = 'Invalid value given for foreign_retailer_indicator.';

        // allowedOptionsSetter() uses loose in_array(), so the value is cast to string first
        return $this->allowedOptionsSetter('foreign_retailer_indicator', $allowed, (string)$value, $message);
    }

    /**
     * Validate and set foreign_retailer_transaction_amount param in major currency units.
     * Null clears the value
     *
     * @param mixed $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setForeignRetailerTransactionAmount($value)
    {
        return $this->parseAmount('foreign_retailer_transaction_amount', $value);
    }

    /**
     * Get Marketplace Data Attributes structure
     *
     * @return array
     */
    protected function getMarketplaceDataAttributesStructure()
    {
        return [
            'foreign_retailer_indicator'          => $this->foreign_retailer_indicator,
            'foreign_retailer_transaction_amount' => $this->getForeignRetailerTransactionAmountMinorUnits()
        ];
    }

    /**
     * Validate the foreign retailer indicator and amount dependency and the amount constraints
     *
     * Runs from checkRequirements(), after populateStructure(). Errors raised while the amounts are
     * converted to minor units (for example InvalidArgument for a currency exponent mismatch) and the
     * existing required-field errors therefore take precedence over the checks below.
     *
     * @return void
     * @throws ErrorParameter
     * @throws InvalidArgument
     */
    protected function validateMarketplaceDataAttributes()
    {
        if ($this->foreign_retailer_transaction_amount === null) {
            return;
        }

        if ($this->foreign_retailer_indicator === null) {
            throw new ErrorParameter(
                'foreign_retailer_indicator is required when foreign_retailer_transaction_amount is provided.'
            );
        }

        $foreignAmount     = $this->getForeignRetailerTransactionAmountMinorUnits();
        $transactionAmount = $this->transformAmount($this->amount, $this->currency);

        if ($this->compareMarketplaceAmounts($foreignAmount, '0') <= 0) {
            throw new ErrorParameter(
                'foreign_retailer_transaction_amount must be greater than zero.'
            );
        }

        if ($this->compareMarketplaceAmounts($foreignAmount, $transactionAmount) > 0) {
            throw new ErrorParameter(
                'foreign_retailer_transaction_amount must not exceed the transaction amount.'
            );
        }
    }

    /**
     * Foreign retailer transaction amount converted to minor currency units
     *
     * @return mixed
     */
    private function getForeignRetailerTransactionAmountMinorUnits()
    {
        if ($this->foreign_retailer_transaction_amount === null) {
            return null;
        }

        return $this->transformAmount($this->foreign_retailer_transaction_amount, $this->currency);
    }

    /**
     * Exact decimal comparison of two amounts.
     * Minor-unit values are compared as integers. On the subsequent recurring path without currency
     * the amounts are not converted, so the scale is the larger number of fractional digits
     *
     * @param string $left
     * @param string $right
     * @return int -1, 0 or 1
     * @throws InvalidArgument
     */
    private function compareMarketplaceAmounts($left, $right)
    {
        $scale = max(
            $this->getMarketplaceAmountScale($left),
            $this->getMarketplaceAmountScale($right)
        );

        return bccomp($left, $right, $scale);
    }

    /**
     * Number of fractional digits of an amount in decimal notation.
     * parseAmount() accepts every numeric value, including exponent notation (for example 1e2),
     * which bcmath cannot compare. Such values are rejected instead of being compared incorrectly
     *
     * @param string $amount
     * @return int
     * @throws InvalidArgument
     */
    private function getMarketplaceAmountScale($amount)
    {
        if (!preg_match('/^[+-]?\d*(?:\.(\d*))?$/', $amount, $matches)) {
            throw new InvalidArgument(
                sprintf(
                    'Unsupported value %s for foreign retailer amount validation. ' .
                    'amount and foreign_retailer_transaction_amount must use decimal notation, for example 10.50.',
                    $amount
                )
            );
        }

        return isset($matches[1]) ? strlen($matches[1]) : 0;
    }
}

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

namespace Genesis\Api\Traits\Request\NonFinancial\Payee;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait OwnershipAttributes
 *
 * @method string getPayeesUniqueId()         Get unique ID of Payee owned by this Owner
 * @method float  getPayeesPercentOwnership() Get the percentage of the payee ownership
 * @method string getOwnersUniqueId()         Get unique ID of Owner owning this Owner
 * @method float  getOwnersPercentOwnership() Get the percentage of the owner ownership
 * @method $this  setPayeesUniqueId($value)   Set unique ID of Payee owned by this Owner
 * @method $this  setOwnersUniqueId($value)   Set unique ID of Owner owning this Owner
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Payee
 */
trait OwnershipAttributes
{
    /**
     * Unique ID of Payee owned by this Owner
     *
     * @var string
     */
    protected $payees_unique_id;

    /**
     * The percentage of the payee ownership in the range of 0.0 to 100.0
     *
     * @var float
     */
    protected $payees_percent_ownership;

    /**
     * Unique ID of Owner owning this Owner
     *
     * @var string
     */
    protected $owners_unique_id;

    /**
     * The percentage of the owner ownership in the range of 0.0 to 100.0
     *
     * @var float
     */
    protected $owners_percent_ownership;

    /**
     * Sets the percentage of the payee ownership.
     *
     * @param float $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setPayeesPercentOwnership($value)
    {
        if (is_null($value)) {
            $this->payees_percent_ownership = null;

            return $this;
        }

        $value = (float)trim($value);

        if ($value < 0.0 || $value > 100.0) {
            throw new InvalidArgument(
                'Percent ownership must be in the range of 0.0 to 100.0'
            );
        }
        $this->payees_percent_ownership = $value;

        return $this;
    }

    /**
     * Sets the percentage of the owner ownership.
     *
     * @param float $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setOwnersPercentOwnership($value)
    {
        if (is_null($value)) {
            $this->owners_percent_ownership = null;

            return $this;
        }

        $value = (float)trim($value);

        if ($value < 0.0 || $value > 100.0) {
            throw new InvalidArgument(
                'Percent ownership must be in the range of 0.0 to 100.0'
            );
        }
        $this->owners_percent_ownership = $value;

        return $this;
    }

    /**
     * Get payees ownership structure
     *
     * @return array
     */
    protected function getPayeesOwnershipStructure()
    {
        return [
            [
                'unique_id'         => $this->payees_unique_id,
                'percent_ownership' => $this->payees_percent_ownership
            ]
        ];
    }

    /**
     * Get owners ownership structure
     *
     * @return array
     */
    protected function getOwnersOwnershipStructure()
    {
        return [
            [
                'unique_id'         => $this->owners_unique_id,
                'percent_ownership' => $this->owners_percent_ownership
            ]
        ];
    }
}

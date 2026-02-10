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

namespace Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class AssociatePayeeWithOwners
 *
 * Associate a Payee belonging to Owners.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee
 *
 * @method string getPayeeUniqueId()               Returns the unique identifier of the Payee
 * @method string getOwnersUniqueId()              Returns the unique identifier of the Owner
 * @method float  getOwnersPercentOwnership()      Returns the percentage of ownership
 * @method $this  setPayeeUniqueId($value)         Sets the unique identifier of the Payee
 * @method $this  setOwnersUniqueId(string $value) Sets the unique identifier of the Owner
 */
class AssociatePayeeWithOwners extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id/owners';

    /**
     * Unique ID of Owner owning this Owner.
     *
     * @var string
     */
    protected $owners_unique_id;

    /**
     * The percentage of the ownership in the range of 0.0 to 100.0.
     *
     * @var float
     */
    protected $owners_percent_ownership;

    /**
     * Sets the percentage of the ownership.
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
     * AssociatePayeeWithOwners constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Updates the request path with payee_unique_id and query parameters.
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':payee_unique_id',
                (string)$this->payee_unique_id,
                self::REQUEST_PATH
            )
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'payee_unique_id',
            'owners_unique_id',
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Returns the request structure.
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'owners' => [
                [
                    'unique_id'         => $this->owners_unique_id,
                    'percent_ownership' => $this->owners_percent_ownership,
                ]
            ]
        ];
    }
}

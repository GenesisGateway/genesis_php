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

namespace Genesis\Api\Request\NonFinancial\Payee\Owners;

use Genesis\Api\Constants\NonFinancial\Payee\OwnerTypes;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\Payee\OwnerAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Country;

/**
 * Class Update
 *
 * Create an Owner record.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee\Owners
 *
 * @method string getOwnerUniqueId() Returns the unique identifier of the Owner
 *
 */
class Update extends BaseRequest
{
    use OwnerAttributes;

    const REQUEST_PATH = 'payee/owners/:owner_unique_id';

    /**
     * The unique identifier of the Owner.
     *
     * @var string
     */
    protected $owner_unique_id;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Sets the owner unique ID
     *
     * @param  string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setOwnerUniqueId($value)
    {
        $this->owner_unique_id = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with owner_unique_id and query parameters.
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':owner_unique_id',
                (string)$this->owner_unique_id,
                self::REQUEST_PATH
            )
        );
    }

    /**
     * Initialize JSON configuration
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->setPatchRequest();
    }

    /**
     * Set validation rules for required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'owner_unique_id',
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Get the request structure for the API call
     *
     * @return array[]
     */
    protected function getRequestStructure()
    {
        return [
            'owner' => $this->getOwnerAttributesStructure()
        ];
    }
}

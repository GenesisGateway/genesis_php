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

namespace Genesis\Api\Request\Base\NonFinancial\Alternatives\Trustly;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Api\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class BaseRequest
 *
 * Trustly APM Services
 *
 * @package Genesis\Api\Request\Base\NonFinancial\Alternatives\Trustly
 *
 * @method string getEmail()
 * @method string getFirstName()
 * @method string getLastName()
 * @method string getMobilePhone()
 * @method string getNationalId()
 * @method string getUserId()
 * @method $this  setFirstName($value)
 * @method $this  setLastName($value)
 * @method $this  setMobilePhone($value)
 * @method $this  setNationalId($value)
 * @method $this  setUserId($value)
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    use BirthDateAttributes;

    /**
     * Customer first name
     *
     * @var string
     */
    protected $first_name;

    /**
     * Customer last name
     *
     * @var string
     */
    protected $last_name;

    /**
     * E-mail of the customer
     *
     * @var string
     */
    protected $email;

    /**
     * Phone number of the customer
     *
     * @var string
     */
    protected $mobile_phone;

    /**
     * National Identifier number of the customer
     *
     * @var string
     */
    protected $national_id;

    /**
     * Unique user identifier defined by merchant in their own system
     *
     * @var string
     */
    protected $user_id;

    /**
     * @var string
     */
    private $request_path;

    /**
     * @param string $requestPath
     */
    public function __construct($requestPath)
    {
        $this->request_path = $requestPath;

        parent::__construct($this->request_path, Builder::JSON, ['v1']);
    }

    /**
     * @param string $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setEmail($value)
    {
        if (empty($value)) {
            $this->email = null;

            return $this;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgument('Invalid email given');
        }

        $this->email = $value;

        return $this;
    }

    /**
     * Generate the proper date format
     *
     * @return string|null
     */
    public function getBirthDate()
    {
        return (empty($this->birth_date)) ? null :
            $this->birth_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the per-request configuration
     *
     * @return void
     * @throws EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        parent::initConfiguration();
        $this->initApiGatewayConfiguration("{$this->getVersion()}/trustly/$this->request_path", true);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $this->treeStructure = CommonUtils::createArrayObject(
            $this->getRequestStructure()
        );
    }
}

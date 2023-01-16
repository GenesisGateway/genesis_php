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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API\Request\NonFinancial\Fx;

use Genesis\API\Request;
use Genesis\API\Request\Base\NonFinancial\Fx\BaseRequest;
use Genesis\Builder;
use Genesis\Utils\Common;

/**
 * Class GetRate
 *
 * This call is used to return information about selected Rate for merchant.
 *
 * @package Genesis\API\Request\NonFinancial\Fx
 */
class GetRate extends BaseRequest
{
    const REQUEST_PATH = 'tiers/:tier_id/rates/:id';

    /**
     * @var int
     */
    protected $tier_id;

    /**
     * @var int
     */
    protected $rate_id;

    /**
     * Rate constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * @param int $tierId
     *
     * @return $this
     */
    public function setTierId($tierId)
    {
        return $this->setField('tier_id', $tierId);
    }

    /**
     * @param int $rateId
     *
     * @return $this
     */
    public function setRateId($rateId)
    {
        return $this->setField('rate_id', $rateId);
    }

    /**
     * @param string $field
     * @param int $value
     *
     * @return $this
     */
    private function setField($field, $value)
    {
        $this->$field = $value;

        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with proper tier and rate ids
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            static::MAIN_REQUEST_PATH . '/' .
            str_replace(
                [':tier_id', ':id'],
                [$this->tier_id, $this->rate_id],
                static::REQUEST_PATH
            )
        );
    }

    /**
     * Configures a Secured Post Request with Xml body
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->config = Common::createArrayObject(
            [
                'protocol' => Request::PROTOCOL_HTTPS,
                'port'     => Request::PORT_HTTPS,
                'type'     => Request::METHOD_GET,
                'format'   => Builder::JSON
            ]
        );
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}

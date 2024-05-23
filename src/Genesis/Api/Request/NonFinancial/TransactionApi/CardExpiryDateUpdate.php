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

namespace Genesis\Api\Request\NonFinancial\TransactionApi;

use DateTime;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class CardExpiryDateUpdate
 * @package Genesis\Api\Request\NonFinancial\TransactionApi
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class CardExpiryDateUpdate extends BaseVersionedRequest
{
    /**
     * Expiration month as printed on credit card
     *
     * @var DateTime $expiration_month
     */
    protected $expiration_month;

    /**
     * Expiration year as printed on credit card
     *
     * @var DateTime $expiration_year
     */
    protected $expiration_year;

    /**
     * Unique identifier of the transaction
     *
     * @var string $transaction_unique_id
     */
    protected $transaction_unique_id;

    /**
     * Endpoint of the request
     *
     * @var string $request_path
     */
    private $request_path;

    /**
     * CardExpiryDateUpdate constructor.
     */
    public function __construct()
    {
        $this->request_path = 'transaction/expiry_date';

        parent::__construct($this->request_path, Builder::XML, ['v1']);
    }

    /**
     * Initialize Network Config parameters
     */
    protected function initXmlConfiguration()
    {
        $this->config = CommonUtils::createArrayObject(
            [
                'protocol' => Request::PROTOCOL_HTTPS,
                'port'     => Request::PORT_HTTPS,
                'type'     => Request::METHOD_PUT,
                'format'   => Builder::XML
            ]
        );
    }

    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->checkDate();
    }


    /**
     * @return CardExpiryDateUpdate
     * @var string $var
     */
    public function setTransactionUniqueId($value)
    {
        $this->transaction_unique_id = $value;

        $this->setRequestPath($this->request_path . '/' . $this->transaction_unique_id);

        return $this;
    }

    /**
     * Expiration month as printed on credit card
     *
     * @param $value
     * @return CardExpiryDateUpdate
     * @throws InvalidArgument
     */
    public function setExpirationMonth($value)
    {
        return $this->parseDate(
            'expiration_month',
            ['n', 'm'],
            $value,
            'Provided expiration_month is invalid.'
        );
    }

    /**
     * Expiration year as printed on credit card
     *
     * @param string $value
     * @return CardExpiryDateUpdate
     * @throws ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setExpirationYear($value)
    {
        return $this->parseDate(
            'expiration_year',
            ['y', 'Y'],
            $value,
            'Provided expiration_year is invalid.'
        );
    }

    /**
     * @return string|null
     */
    public function getExpirationMonth()
    {
        if ($this->expiration_month instanceof DateTime) {
            return $this->expiration_month->format('m');
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getExpirationYear()
    {
        if ($this->expiration_year instanceof DateTime) {
            return $this->expiration_year->format('Y');
        }

        return null;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'expiration_month',
            'expiration_year',
            'transaction_unique_id'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'update_card_expiration_request' => [
                'expiration_month' => $this->getExpirationMonth(),
                'expiration_year'  => $this->getExpirationYear()
            ]
        ];
    }

    /**
     * Validate provided date before sending the request
     *
     * @throws InvalidArgument
     */
    private function checkDate()
    {
        $now = (new DateTime())
            ->modify('last day of this month')
            ->setTime(23, 59, 0);

        $date = DateTime::createFromFormat(
            'Y-m',
            $this->expiration_year->format('Y') . '-' . $this->expiration_month->format('m')
        )
            ->modify('last day of this month')
            ->setTime(23, 59, 0);

        if ($date < $now) {
            throw new InvalidArgument(
                'Provided date must be in the future.'
            );
        }
    }
}

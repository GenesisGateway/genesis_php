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
namespace Genesis\API\Request\NonFinancial\Fx;

use Genesis\API\Request\Base\NonFinancial\Fx\BaseRequest;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * Class SearchRate
 *
 * This call is used to return information about selected Rate by currency pair.
 *
 * @package Genesis\API\Request\NonFinancial\Fx
 */
class SearchRate extends BaseRequest
{
    const REQUEST_PATH = 'tiers/:tier_id/rates/search';

    /**
     * @var string
     */
    protected $source_currency;

    /**
     * @var string
     */
    protected $target_currency;

    /**
     * Tier constructor.
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
        $this->setRequestPath(
            static::MAIN_REQUEST_PATH . '/' .
            str_replace(':tier_id', $tierId, static::REQUEST_PATH)
        );

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setSourceCurrency($currency)
    {
        if ($this->target_currency === $currency) {
            $this->throwExceptionTargetEqualsSourceCurrency();
        }

        $this->source_currency = $currency;

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setTargetCurrency($currency)
    {
        if ($this->source_currency === $currency) {
            $this->throwExceptionTargetEqualsSourceCurrency();
        }

        $this->target_currency = $currency;

        return $this;
    }

    /**
     * @throws InvalidArgument
     */
    private function throwExceptionTargetEqualsSourceCurrency()
    {
        throw new InvalidArgument('Source currency must be different from target currency');
    }

    protected function setRequiredFields()
    {
        $requiredFields = [
            'source_currency',
            'target_currency'
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'source_currency' => \Genesis\Utils\Currency::getList(),
            'target_currency' => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = Common::createArrayObject($requiredFieldValues);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'source_currency' => $this->source_currency,
            'target_currency' => $this->target_currency
        ];
    }
}

<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\MarketplaceDataAttributes;
use Genesis\Api\Traits\RestrictedSetter;
use Genesis\Utils\Currency;

/**
 * Class MarketplaceDataAttributesStub
 *
 * Used to spec MarketplaceDataAttributes Trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial
 *
 * @method $this setAmount($value)
 * @method $this setCurrency($value)
 */
class MarketplaceDataAttributesStub
{
    use MagicAccessors;
    use MarketplaceDataAttributes;
    use RestrictedSetter;

    /**
     * Transaction amount in major currency units, read by the trait
     *
     * @var string
     */
    protected $amount;

    /**
     * Transaction currency, read by the trait
     *
     * @var string
     */
    protected $currency;

    /**
     * Expose the protected structure builder
     *
     * @return array
     */
    public function getStructure()
    {
        return $this->getMarketplaceDataAttributesStructure();
    }

    /**
     * Expose the protected validation method
     *
     * @return void
     */
    public function publicValidate()
    {
        $this->validateMarketplaceDataAttributes();
    }

    /**
     * Same conversion as Genesis\Api\Request::transformAmount()
     *
     * @param string $amount
     * @param string $currency
     *
     * @return string|false
     */
    protected function transformAmount($amount = '', $currency = '')
    {
        if (is_numeric($amount) && !empty($currency)) {
            return Currency::amountToExponent($amount, $currency);
        }

        return false;
    }
}

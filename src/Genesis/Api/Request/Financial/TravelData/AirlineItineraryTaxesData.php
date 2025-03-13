<?php

namespace Genesis\Api\Request\Financial\TravelData;

use Genesis\Api\Request\Financial\TravelData\Base\AidAttributes;
use Genesis\Exceptions\InvalidArgument;

class AirlineItineraryTaxesData extends AidAttributes
{
    /**
     * @var int Fee amount of travel.
     */
    protected $feeAmount;

    /**
     * @var string Fee type
     */
    protected $feeType;

    /**
     * AirlineItineraryTaxesData constructor.
     *
     * @throws InvalidArgument
     */
    public function __construct($feeAmount = null, $feeType = null)
    {
        $this->setFeeAmount($feeAmount);
        $this->setFeeType($feeType);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryTaxesData
     */
    public function setFeeAmount($value)
    {
        if ($value === null) {
            $this->feeAmount = null;

            return $this;
        }
         $this->feeAmount = (int)$value;
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryTaxesData
     *
     * @throws InvalidArgument
     */
    public function setFeeType($value)
    {
        if ($value === null) {
            $this->feeType = null;

            return $this;
        }

        return $this->setLimitedString('feeType', $value, 1, 8);
    }

    /**
     * Return the structure name
     *
     * @return string
     */
    public function getStructureName()
    {
        return 'taxes';
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'fee_amount'         => $this->feeAmount,
            'fee_type'           => $this->feeType
        ];
    }
}

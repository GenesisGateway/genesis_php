<?php


namespace Genesis\API\Request\Financial\TravelData\Base;

use Genesis\API\Traits\RestrictedSetter;

abstract class AidAttributes
{
    use RestrictedSetter;

    public static function getMaxCount()
    {
        return 10;
    }

    abstract public function toArray();

    abstract public function getStructureName();
}

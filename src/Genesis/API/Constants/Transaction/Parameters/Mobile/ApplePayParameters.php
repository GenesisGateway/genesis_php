<?php

namespace Genesis\API\Constants\Transaction\Parameters\Mobile;

use Genesis\Utils\Common;

class ApplePayParameters
{
    private static $payment_types = [
        'authorize',
        'recurring'
    ];

    /**
     * Get payment allowed payment
     *
     * @return array
     */
    public static function getAllowedPaymentTypes()
    {
        return self::$payment_types;
    }
}

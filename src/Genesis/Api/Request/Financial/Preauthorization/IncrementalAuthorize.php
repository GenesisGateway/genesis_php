<?php

namespace Genesis\Api\Request\Financial\Preauthorization;

use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial;

/**
 * Class IncrementalAuthorize
 * @package Genesis\Api\Request\Financial\Preauthorization
 */
class IncrementalAuthorize extends Financial\Reference
{
    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::INCREMENTAL_AUTHORIZE;
    }
}

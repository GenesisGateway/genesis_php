<?php

namespace Genesis\API\Request\Financial\Preauthorization;

use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\Base\Financial;

/**
 * Class IncrementalAuthorize
 * @package Genesis\API\Request\Financial\Preauthorization
 */
class PartialReversal extends Financial\Reference
{
    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::PARTIAL_REVERSAL;
    }
}

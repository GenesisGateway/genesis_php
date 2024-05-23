<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\Request\Financial\FxRateAttributes;

class FxRateAttributesStub
{
    use FxRateAttributes;

    public function getFxRateId()
    {
        return $this->fx_rate_id;
    }
}

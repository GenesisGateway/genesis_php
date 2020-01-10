<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\Request\Financial\FxRateAttributes;

class FxRateAttributesStub
{
    use FxRateAttributes;

    public function getFxRateId()
    {
        return $this->fx_rate_id;
    }
}

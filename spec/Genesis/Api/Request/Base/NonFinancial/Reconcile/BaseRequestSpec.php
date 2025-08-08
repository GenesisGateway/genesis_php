<?php

namespace spec\Genesis\Api\Request\Base\NonFinancial\Reconcile;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\Request\NonFinancial\Reconcile\BaseRequestStub;

class BaseRequestSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BaseRequestStub::class);
    }
}

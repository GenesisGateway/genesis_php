<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\PendingPaymentAttributesStub;
use spec\SharedExamples\Faker;

class PendingPaymentAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PendingPaymentAttributesStub::class);
    }

    public function it_should_set_return_pending_url()
    {
        $this->shouldNotThrow()->during(
            'setReturnPendingUrl',
            [Faker::getInstance()->url]
        );
    }

    public function it_should_get_return_pending_url()
    {
        $url = Faker::getInstance()->url;
        $this->setReturnPendingUrl($url);

        $this->getReturnPendingUrl()->shouldBe($url);
    }
}

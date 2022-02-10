<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

use spec\SharedExamples\Faker;

trait PendingPaymentAttributesExamples
{
    public function it_should_accept_valid_url_for_return_pending_url()
    {
        $this->shouldNotThrow()->during('setReturnPendingUrl',
            [Faker::getInstance()->url()]
        );
    }

    public function it_should_fail_with_invalid_url_for_return_pending_url()
    {
        $this->shouldThrow()->during('setReturnPendingUrl',
            [Faker::getInstance()->word()]
        );
    }

    public function it_should_return_string_for_return_pending_url()
    {
        $this->setReturnPendingUrl(Faker::getInstance()->url())
            ->getReturnPendingUrl()->shouldBeString();
    }

    public function it_should_not_fail_with_null_value_for_return_pending_url()
    {
        $this->shouldNotThrow()->during('setReturnPendingUrl', [null]);
    }

    public function it_should_contain_pending_url_key()
    {
        $this->setRequestParameters();

        $this->setReturnPendingUrl(Faker::getInstance()->url);
        $this->getDocument()->shouldContain('<return_pending_url>');
    }
}

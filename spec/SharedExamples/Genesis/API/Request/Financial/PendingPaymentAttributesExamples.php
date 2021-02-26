<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

use spec\SharedExamples\Faker;

trait PendingPaymentAttributesExamples
{
    public function it_should_contain_pending_url_key()
    {
        $this->setRequestParameters();

        $this->setReturnPendingUrl(Faker::getInstance()->url);
        $this->getDocument()->shouldContain('<return_pending_url>');
    }
}

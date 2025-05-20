<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPayment;
use spec\SharedExamples\Faker;

trait PurposeOfPaymentAttributesExamples
{
    public function it_should_set_purpose_of_payment()
    {
        $this->setRequestParameters();
        $this->setPurposeOfPayment(Faker::getInstance()->randomElement(PurposeOfPayment::getAll()));
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_purpose_of_payment()
    {
        $this->setRequestParameters();

        $this->setPurposeOfPayment(Faker::getInstance()->randomElement(PurposeOfPayment::getAll()));
        $this->getDocument()->shouldContain('<purpose_of_payment>');
    }
}

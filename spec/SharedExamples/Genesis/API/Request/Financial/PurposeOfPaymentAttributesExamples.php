<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

use spec\SharedExamples\Faker;

trait PurposeOfPaymentAttributesExamples
{
    public function it_should_set_purpose_of_payment()
    {
        $this->setRequestParameters();
        $this->setPurposeOfPayment(Faker::getInstance()->lexify('??????'));
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_purpose_of_payment()
    {
        $this->setRequestParameters();

        $this->setPurposeOfPayment(Faker::getInstance()->lexify('??????'));
        $this->getDocument()->shouldContain('<purpose_of_payment>');
    }
}

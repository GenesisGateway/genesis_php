<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

trait AllowedZeroAmount
{
    public function it_should_allow_zero_amount()
    {
        $this->setRequestParameters();
        $this->setAmount(0);

        $this->shouldNotThrow()->during('getDocument');
    }
}

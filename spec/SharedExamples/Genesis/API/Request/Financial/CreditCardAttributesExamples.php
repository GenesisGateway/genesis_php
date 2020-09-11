<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;

trait CreditCardAttributesExamples
{
    public function it_should_fail_without_expiration_month()
    {
        $this->setRequestParameters();
        $this->setExpirationMonth(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_without_expiration_year()
    {
        $this->setRequestParameters();
        $this->setExpirationYear(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }
}

<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\Santander;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\SupportedCountryCodesExample;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class SantanderSpec extends ObjectBehavior
{
    use RequestExamples, SupportedCountryCodesExample, AsyncAttributesExample, PendingPaymentAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Santander::class);
    }

    protected function getExpectedValidCountryCodes()
    {
        return ['AR', 'BR', 'MX', 'CL'];
    }
}

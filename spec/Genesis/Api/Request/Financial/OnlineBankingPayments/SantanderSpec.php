<?php

namespace spec\Genesis\Api\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Request\Financial\OnlineBankingPayments\Santander;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\SupportedCountryCodesExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class SantanderSpec extends ObjectBehavior
{
    use AsyncAttributesExample;
    use NeighborhoodAttributesExamples;
    use PendingPaymentAttributesExamples;
    use RequestExamples;
    use SupportedCountryCodesExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Santander::class);
    }

    protected function getExpectedValidCountryCodes()
    {
        return ['AR', 'BR', 'MX', 'CL'];
    }
}

<?php

namespace spec\Genesis\Api\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Request\Financial\OnlineBankingPayments\Bancomer;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class BancomerSpec extends ObjectBehavior
{
    use AsyncAttributesExample;
    use NeighborhoodAttributesExamples;
    use PendingPaymentAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Bancomer::class);
    }

    public function it_should_fail_when_country_not_valid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setConsumerReference('1234');
        $this->setNationalId('1234');
        $this->setCurrency('USD');
        $this->setBillingCountry('MX');
    }
}

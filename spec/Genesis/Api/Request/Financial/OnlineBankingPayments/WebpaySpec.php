<?php

namespace spec\Genesis\Api\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Request\Financial\OnlineBankingPayments\Webpay;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class WebpaySpec extends ObjectBehavior
{
    use AsyncAttributesExample;
    use NeighborhoodAttributesExamples;
    use PendingPaymentAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Webpay::class);
    }

    public function it_should_fail_when_country_is_incorrect()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow('Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setConsumerReference('1234');
        $this->setNationalId('1234');
        $this->setCurrency('USD');
        $this->setBillingCountry('CL');
    }
}

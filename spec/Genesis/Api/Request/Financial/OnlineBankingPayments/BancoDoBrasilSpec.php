<?php

namespace spec\Genesis\Api\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Request\Financial\OnlineBankingPayments\BancoDoBrasil;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\Financial\BirthDateAttributesExample;

class BancoDoBrasilSpec extends ObjectBehavior
{
    use AsyncAttributesExample;
    use BirthDateAttributesExample;
    use NeighborhoodAttributesExamples;
    use PendingPaymentAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(BancoDoBrasil::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'billing_country',
            'return_success_url',
            'return_failure_url'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setConsumerReference('1234');
        $this->setNationalId('1234');
        $this->setCurrency('USD');
        $this->setBillingCountry('BR');
    }

    public function it_should_fail_when_country_not_br_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_set_consumer_reference_correctly()
    {
        $this->shouldNotThrow()->during(
            'setConsumerReference',
            [str_repeat('8', $this->object->getWrappedObject()->getMaxConsumerReferenceLen())]
        );
    }

    public function it_should_set_national_id_correctly()
    {
        $this->shouldNotThrow()->during(
            'setNationalId',
            [str_repeat('8', $this->object->getWrappedObject()->getNationalIdLen())]
        );
    }

    public function it_should_fail_when_consumer_reference_is_invalid()
    {
        $this->shouldThrow()->during(
            'setConsumerReference',
            [str_repeat('8', $this->object->getWrappedObject()->getMaxConsumerReferenceLen() + 1)]
        );
    }

    public function it_should_fail_when_national_id_is_invalid()
    {
        $this->shouldThrow()->during(
            'setNationalId',
            [str_repeat('8', $this->object->getWrappedObject()->getNationalIdLen() + 1)]
        );
    }
}

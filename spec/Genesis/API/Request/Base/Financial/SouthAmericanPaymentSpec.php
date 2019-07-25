<?php

namespace spec\Genesis\API\Request\Base\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Base\Request\Financial\SouthAmericanPaymentStub;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class SouthAmericanPaymentSpec extends ObjectBehavior
{
    use RequestExamples;

    public function let()
    {
        $this->beAnInstanceOf(SouthAmericanPaymentStub::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency'
        ]);
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

    public function it_should_set_birth_date_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBirthDate',
            ['31-11-1999']
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

    public function it_should_fail_when_birth_date_is_invalid()
    {
        $this->shouldThrow()->during(
            'setBirthDate',
            ['30.10.1999']
        );
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setConsumerReference('1234');
        $this->setNationalId('1234');
        $this->setCurrency('USD');
        $this->setBillingCountry('CO');
    }
}

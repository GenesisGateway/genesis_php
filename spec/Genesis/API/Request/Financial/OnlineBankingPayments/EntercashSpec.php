<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\Entercash;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class EntercashSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Entercash::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'usage',
            'remote_ip',
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

        $this->setRemoteIp($this->getFaker()->ipv4);
        $this->setConsumerReference('4444');
        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
    }

    public function it_should_fail_when_country_invalid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_consumer_reference_invalid_param()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('setConsumerReference', [
            str_repeat('8', $this->object->getWrappedObject()->getMaxConsumerReferenceLen() + 1)
        ]);
    }

    public function it_should_fail_when_de_iban_invalid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('DE');
        $this->shouldThrow()->during('setIban', ['BG1234']);
    }

    public function it_should_fail_when_at_iban_invalid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('AT');
        $this->shouldThrow()->during('setIban', ['BG1234']);
    }

    public function it_should_set_de_iban_correctly()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('DE');
        $this->shouldNotThrow()->during('setIban', ['DE12345678901234567890']);
    }

    public function it_should_set_at_iban_correctly()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('AT');
        $this->shouldNotThrow()->during('setIban', ['AT123456789123456789']);
    }
}

<?php

namespace spec\Genesis\API\Request\Financial\CashPayments;

use Genesis\API\Request\Financial\CashPayments\Pix;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PixSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'document_id',
            'billing_first_name',
            'billing_last_name'
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Pix::class);
    }

    public function it_should_fail_when_country_is_invalid()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_document_id()
    {
        $this->setDocumentId('123ABC');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setDocumentId('12345678901');
        $this->setCurrency('BRL');
        $this->setBillingCountry('BR');
    }
}

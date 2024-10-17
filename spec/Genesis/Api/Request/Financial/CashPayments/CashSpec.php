<?php

namespace spec\Genesis\Api\Request\Financial\CashPayments;

use Genesis\Api\Constants\Transaction\Parameters\CashPayments\CashPaymentTypes;
use Genesis\Api\Request\Financial\CashPayments\Cash;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CashSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'remote_ip',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'payment_type',
            'document_id',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Cash::class);
    }

    public function it_should_set_parameters()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_document_id()
    {
        $this->setDocumentId('123ABC');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_currency()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_cash_payment_type()
    {
        $this->setRequestParameters();
        $this->setPaymentType('invalid');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('MXN');
        $this->setDocumentId('12345678901');
        $this->setPaymentType($this->getFaker()->randomElement(CashPaymentTypes::getAll()));
    }
}

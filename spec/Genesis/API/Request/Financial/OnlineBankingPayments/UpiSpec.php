<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\Upi;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class UpiSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Upi::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'virtual_payment_address',
            'billing_country'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setVirtualPaymentAddress('someone@bank');
        $this->setCurrency('INR');
        $this->setBillingCountry('IN');
        $this->setDocumentId('ABCDE1234F');
    }

    public function it_should_have_proper_structure()
    {
        $this->setRequestParameters();

        $this->setCustomerPhone('123456');

        $attributes = [
            'transaction_type',
            'transaction_id',
            'usage',
            'remote_ip',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'customer_email',
            'customer_phone',
            'document_id',
            'virtual_payment_address',
            'country'
        ];

        foreach ($attributes as $attribute)
        {
            $this->getDocument()->shouldContain($attribute);
        }
    }

    public function it_should_fail_with_unsuported_currency()
    {
        $this->setRequestParameters();

        $this->setCurrency('AED');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }
}

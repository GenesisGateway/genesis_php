<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\Ideal\AllowedBanks;
use Genesis\API\Request\Financial\OnlineBankingPayments\Ideal;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class IdealSpec extends ObjectBehavior
{
    use RequestExamples, PendingPaymentAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Ideal::class);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry('NL');
    }

    public function it_should_fail_when_unsupported_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('ZZ');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_unset_bic()
    {
        $this->setRequestParameters();
        $this->setBic('');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_not_allowed_bic_value()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBic',
            ['INVALID']
        );
    }

    public function it_should_not_fail_with_allowed_bic_value()
    {
        $this->shouldNotThrow()->during(
            'setBic',
            [Faker::getInstance()->randomElement(AllowedBanks::getAll())]
        );
    }
}

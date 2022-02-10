<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\PostFinance;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PostFinanceSpec extends ObjectBehavior
{
    use RequestExamples, AsyncAttributesExample, PendingPaymentAttributesExamples;

    /**
     * Allowed currencies
     *
     * @var array $currencies
     */
    private $currencies = ['EUR', 'CHF'];

    /**
     * Allowed country
     *
     * @var string $country
     */
    private $country    = 'CH';

    public function it_is_initializable()
    {
        $this->shouldHaveType(PostFinance::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'billing_country'
        ]);
    }

    public function it_should_fail_with_invalid_currency()
    {
        $this->setRequestParameters();
        $this->setCurrency('CNY');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_billing_country()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BR');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_have_proper_structure()
    {
        $this->setRequestParameters();

        $parameters = [
            'transaction_type',
            'transaction_id',
            'usage',
            'remote_ip',
            'return_success_url',
            'return_failure_url',
            'amount'
        ];

        foreach ($parameters as $parameter) {
            $this->getDocument()->shouldContain("<$parameter>");
        }
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCustomerPhone(Faker::getInstance()->phoneNumber);
        $this->setCurrency(Faker::getInstance()->randomElement($this->currencies));
        $this->setBillingCountry($this->country);
        $this->setShippingCountry($this->country);
    }
}

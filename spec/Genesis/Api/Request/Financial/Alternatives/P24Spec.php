<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives;

use Genesis\Api\Constants\Transaction\Parameters\Alternatives\P24\BankCodes;
use Genesis\Api\Request\Financial\Alternatives\P24;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class P24Spec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    private $invalidBankCode = 123456789;

    public function it_is_initializable()
    {
        $this->shouldHaveType(P24::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_missing_email_parameters()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerEmail', [ '' ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameters()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_unsupported_bank_code_based_on_currency()
    {
        $this->setRequestParameters();
        $this->setBankCode($this->invalidBankCode);

        $this->setCurrency('EUR');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');

        $this->setCurrency('PLN');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_with_supported_bank_code_based_on_currency()
    {
        $this->setRequestParameters();
        $this->setBankCode(Faker::getInstance()->randomElement(BankCodes::getAll()));

        $this->setCurrency('EUR');
        $this->shouldNotThrow()->during('getDocument');

        $this->setCurrency('PLN');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_string_value_for_bank_code()
    {
        $this->setRequestParameters();
        $this->setBankCode((string) Faker::getInstance()->randomElement(BankCodes::getAll()));
        $this->setCurrency('EUR');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_empty_bank_code()
    {
        $this->setRequestParameters();
        $this->setCurrency('EUR');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_validate_bank_code_for_other_currencies()
    {
        $this->setRequestParameters();
        $this->setCurrency('AED');
        $this->setBankCode($this->invalidBankCode);

        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );

        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCustomerEmail($faker->email);

        $this->setBillingCountry('NL');

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
    }
}

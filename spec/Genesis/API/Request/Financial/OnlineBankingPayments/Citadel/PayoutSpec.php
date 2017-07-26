<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\Citadel;

use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class PayoutSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\OnlineBankingPayments\Citadel\Payout');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_amount_param()
    {
        $this->setRequestParameters();
        $this->setAmount(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('NR');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_holder_name_parameter()
    {
        $this->setRequestParameters();
        $this->setHolderName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_customer_email_parameter()
    {
        $this->setRequestParameters();
        $this->setCustomerEmail(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_de_iban_parameter()
    {
        $this->setRequestParameters();
        $this->setIban(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_de_swift_code_parameter()
    {
        $this->setRequestParameters();
        $this->setSwiftCode(null);
        $this->shouldThrow()->during('getDocument');
    }
    
    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setHolderName($faker->name);
        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerEmail($faker->email);
        $this->setBillingCountry('DE');
        $this->setIban($faker->iban('DE'));
        $this->setSwiftCode($faker->swiftBicNumber);
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}

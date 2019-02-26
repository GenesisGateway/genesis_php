<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class PayoutSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payout');
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

    public function it_should_fail_when_missing_return_success_url_param()
    {
        $this->setRequestParameters();
        $this->setReturnSuccessUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_return_failure_url_param()
    {
        $this->setRequestParameters();
        $this->setReturnFailureUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_remote_ip_param()
    {
        $this->setRequestParameters();
        $this->setRemoteIp(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_bank_account_name_param()
    {
        $this->setRequestParameters();
        $this->setBankAccountName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_bank_account_number_param()
    {
        $this->setRequestParameters();
        $this->setBankAccountNumber(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_first_name_param()
    {
        $this->setRequestParameters();
        $this->setBillingFirstName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_last_name_param()
    {
        $this->setRequestParameters();
        $this->setBillingLastName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_state_param()
    {
        $this->setRequestParameters();
        $this->setBillingState(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_country_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_bank_code_for_IDR_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('IDR');
        $this->setBankCode(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_bank_name_for_THB_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('THD');
        $this->setBankName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_bank_name_for_CNY_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('CNY');
        $this->setBankName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_bank_branch_for_CNY_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('CNY');
        $this->setBankBranch(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_incorrect_bank_account_number_for_CNY_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('CNY');
        $this->setBankAccountNumber($this->generateBankAccountNumber(15));
        $this->shouldThrow()->during('getDocument');
    }

    private function generateBankAccountNumber ($length = 19)
    {
        return substr(str_shuffle(str_repeat('0123456789', 5)), 1, $length);
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
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setRemoteIp($faker->ipv4);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency($faker->randomElement([
            'CNY', 'THB', 'IDR'
        ]));
        $this->setBankAccountName($faker->name);
        $this->setBankAccountNumber($this->generateBankAccountNumber()); // Bank account number should be exactly 19 digits
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
        $this->setBankName($faker->text(10));
        $this->setBankBranch($faker->text(20));
        $this->setBankCode($faker->text(10));
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

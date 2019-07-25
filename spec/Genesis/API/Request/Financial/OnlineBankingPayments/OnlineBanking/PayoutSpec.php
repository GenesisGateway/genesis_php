<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payout;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PayoutSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payout::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'remote_ip',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'bank_account_name',
            'bank_account_number',
            'billing_first_name',
            'billing_last_name',
            'billing_state',
            'billing_country'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

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
        // Bank account number should be exactly 19 digits
        $this->setBankAccountNumber($this->generateBankAccountNumber());
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
        $this->setBankName($faker->text(10));
        $this->setBankBranch($faker->text(20));
        $this->setBankCode($faker->text(10));
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
}

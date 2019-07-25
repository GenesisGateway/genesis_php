<?php

namespace spec\Genesis\API\Request\Financial\Alternatives;

use Genesis\API\Request\Financial\Alternatives\INPay;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class INPaySpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(INPay::class);
    }

    public function it_should_fail_when_no_auth_or_payout_params_supplied()
    {
        $this->setBaseRequestParameters();
        $this->shouldThrow()->during('getDocument');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters(false);
        $this->getDocument()->shouldNotBeEmpty();

        $this->setRequestParameters(true);
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_missing_email_parameters()
    {
        $this->setRequestParameters(false);
        $this->shouldThrow()->during('setCustomerEmail', [ '' ]);
    }

    public function it_should_fail_when_unsupported_billing_country_parameter()
    {
        $this->setRequestParameters(false);
        $this->setBillingCountry('ZZ');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters(false);
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_order_id()
    {
        $this->setRequestParameters(true);
        $this->setPayoutOrderId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_bank_country()
    {
        $this->setRequestParameters(true);
        $this->setPayoutBankCountry(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_bank_name()
    {
        $this->setRequestParameters(true);
        $this->setPayoutBankName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_swift()
    {
        $this->setRequestParameters(true);
        $this->setPayoutSwift(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_acc_number()
    {
        $this->setRequestParameters(true);
        $this->setPayoutAccNumber(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_bank_address()
    {
        $this->setRequestParameters(true);
        $this->setPayoutBankAddress(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_owner_name()
    {
        $this->setRequestParameters(true);
        $this->setPayoutOwnerName(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_payout_tran_without_payout_owner_address()
    {
        $this->setRequestParameters(true);
        $this->setPayoutOwnerAddress(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setBaseRequestParameters()
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

        $this->setBillingCountry(
            $faker->randomElement(
                \Genesis\Utils\Country::getList()
            )
        );

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
    }

    protected function setAuthTransactionParameters()
    {
        $faker = $this->getFaker();

        $this->setIsPayout(false);

        $this->setCustomerBankId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setOrderDescription($faker->text);
    }

    protected function setPayoutTransactionParameters()
    {
        $faker = $this->getFaker();

        $this->setIsPayout(true);

        $this->setPayoutOrderId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setPayoutBankCountry($faker->countryCode);
        $this->setPayoutBankName($faker->name);
        $this->setPayoutSwift($faker->name);
        $this->setPayoutAccNumber($faker->bankAccountNumber);
        $this->setPayoutBankAddress($faker->streetAddress);
        $this->setPayoutOwnerName($faker->name);
        $this->setPayoutOwnerAddress($faker->streetAddress);
    }

    /**
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    protected function setRequestParameters($isPayout)
    {
        $this->setBaseRequestParameters();
        if ($isPayout) {
            $this->setPayoutTransactionParameters();
        } else {
            $this->setAuthTransactionParameters();
        }
    }
}

<?php

namespace spec\Genesis\API\Request\Financial\Alternatives;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class INPaySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Alternatives\INPay');
    }

    public function it_should_fail_when_no_auth_or_payout_params_supplied()
    {
        $this->setBaseRequestParameters();
        $this->shouldThrow()->during('getDocument');
    }

    public function it_can_build_auth_transaction_structure()
    {
        $this->setRequestParameters(false);
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_can_build_payout_transaction_structure()
    {
        $this->setRequestParameters(true);
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_email_parameters()
    {
        $this->setRequestParameters(false);
        $this->setCustomerEmail(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_currency_parameters()
    {
        $this->setRequestParameters(false);
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_country_parameters()
    {
        $this->setRequestParameters(false);
        $this->setBillingCountry(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_auth_transaction_without_notify_url()
    {
        $this->setRequestParameters(false);
        $this->setNotificationUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_auth_transaction_without_customer_bank_id()
    {
        $this->setRequestParameters(false);
        $this->setCustomerBankId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_auth_transaction_without_order_description()
    {
        $this->setRequestParameters(false);
        $this->setOrderDescription(null);
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

        $this->setCurrency('EUR');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCustomerEmail($faker->email);

        $this->setBillingCountry($faker->countryCode);

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
    }

    protected function setAuthTransactionParameters()
    {
        $faker = $this->getFaker();

        $this->setIsPayout(false);

        $this->setNotificationUrl($faker->url);
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

    protected function getFaker()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        return $faker;
    }

    public function getMatchers()
    {
        return array(
            'beEmpty'       => function ($subject) {
                return empty($subject);
            },
            'contain'       => function ($subject, $arg) {
                return (stripos($subject, $arg) !== false);
            },
        );
    }
}

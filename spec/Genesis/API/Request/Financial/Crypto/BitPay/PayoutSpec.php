<?php

namespace spec\Genesis\API\Request\Financial\Crypto\BitPay;

use Genesis\API\Request\Financial\Crypto\BitPay\Payout;
use PhpSpec\ObjectBehavior;

class PayoutSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Crypto\BitPay\Payout');
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

    public function it_should_fail_when_missing_required_crypto_address_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCryptoAddress', [null]);
    }

    public function it_should_fail_when_invalid_crypto_address_param()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCryptoAddress', ['1FTgzPJCbpCWYfF6VxPdmCMPUDfffgut2h']);
    }

    public function it_should_fail_when_invalid_required_crypto_wallet_provider_param()
    {
        $this->setRequestParameters();
        $this->setCryptoWalletProvider(null);
        $this->shouldThrow()->during('getDocument');
        $this->setCryptoWalletProvider('TradeOgre');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_set_valid_crypto_wallet_provider_param()
    {
        $walletProviders = [
            Payout::WALLET_PROVIDER_BITGO,
            Payout::WALLET_PROVIDER_UPHOLD,
            Payout::WALLET_PROVIDER_CIRCLE,
            Payout::WALLET_PROVIDER_COINBASE,
            Payout::WALLET_PROVIDER_GDAX,
            Payout::WALLET_PROVIDER_GEMINI,
            Payout::WALLET_PROVIDER_ITBIT,
            Payout::WALLET_PROVIDER_KRAKEN
        ];
        $this->setRequestParameters();

        foreach ($walletProviders AS $provider) {
            $this->setCryptoWalletProvider($provider);
            $this->shouldNotThrow()->during('getDocument');
        }
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerEmail($faker->email);
        $this->setCryptoAddress('1FTgzPJCbpCWYfF6VxPdmCMPUDBfygut2h');
        $this->setCryptoWalletProvider(Payout::WALLET_PROVIDER_GDAX);
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

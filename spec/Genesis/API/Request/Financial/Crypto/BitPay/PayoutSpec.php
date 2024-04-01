<?php

namespace spec\Genesis\API\Request\Financial\Crypto\BitPay;

use Genesis\API\Request\Financial\Crypto\BitPay\Payout;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class PayoutSpec extends ObjectBehavior
{
    use RequestExamples, NeighborhoodAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payout::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency'
        ]);
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
        $faker = $this->getFaker();

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
}

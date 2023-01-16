<?php

namespace spec\Genesis\API\Request\Financial\Wallets;

use Genesis\API\Request\Financial\Wallets\eZeeWallet;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

// @codingStandardsIgnoreStart
class eZeeWalletSpec extends ObjectBehavior
// @codingStandardsIgnoreEnd
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(eZeeWallet::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'source_wallet_id'
        ]);
    }

    public function it_should_encode_password_correctly()
    {
        $faker = \Faker\Factory::create();

        $password = $faker->streetName;

        $this->setRequestParameters();
        $this->setSourceWalletPwd($password);
        $this->getSourceWalletPwd()->shouldBeLike($password);
        $this->getDocument()->shouldContain(base64_encode($password));
    }

    public function it_should_pass_the_password_correctly_if_previously_encoded()
    {
        $faker = \Faker\Factory::create();

        $password = base64_encode($faker->streetName);

        $this->setRequestParameters();
        $this->setSourceWalletPwd($password);
        $this->getSourceWalletPwd()->shouldBeLike($password);
        $this->getDocument()->shouldContain($password);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency('USD');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setSourceWalletId($faker->uuid);
        $this->setSourceWalletPwd($faker->streetName);

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setNotificationUrl($faker->url);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty'       => function ($subject) {
                return empty($subject);
            },
            'beDecodedLike' => function ($subject, $arg) {
                return strcasecmp($subject, base64_decode($arg));
            },
            'contain'       => function ($subject, $arg) {
                return (stripos($subject, $arg) !== false);
            },
        );
    }
}

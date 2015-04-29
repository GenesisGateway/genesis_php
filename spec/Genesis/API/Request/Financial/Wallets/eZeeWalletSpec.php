<?php

namespace spec\Genesis\API\Request\Financial\Wallets;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class eZeeWalletSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Wallets\eZeeWallet');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setSourceWalletId(null);
        $this->shouldThrow()->during('getDocument');
    }

    function it_should_encode_password_correctly()
    {
        $faker = \Faker\Factory::create();

        $password = $faker->streetName;

        $this->setRequestParameters();
        $this->setSourceWalletPwd($password);
        $this->getSourceWalletPwd()->shouldBeLike($password);
        $this->getDocument()->shouldContain(base64_encode($password));
    }

    function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency('USD');
        $this->setAmount(mt_rand(100, 100000));

        $this->setSourceWalletId($faker->uuid);
        $this->setSourceWalletPwd($faker->streetName);

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
    }

    public function getMatchers()
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

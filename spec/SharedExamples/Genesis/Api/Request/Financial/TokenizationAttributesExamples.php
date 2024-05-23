<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Exceptions\ErrorParameter;

trait TokenizationAttributesExamples
{
    public function it_should_not_fail_when_missing_consumer_id()
    {
        $this->setRequestParameters();
        $this->setConsumerId(null);

        $this->shouldNotThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_with_token_and_card_number_in_same_request()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setToken($faker->word);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_with_remember_card_and_without_card_number()
    {
        $this->setRequestParameters();
        $this->setRememberCard(true);
        $this->setCardNumber(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_with_both_set_remember_card_and_token()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setCardNumber(null);

        $this->setToken($faker->word);
        $this->setRememberCard(true);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_without_token_card_number_and_remember_card()
    {
        $this->setRequestParameters();
        $this->setCardNumber(null);
        $this->setToken(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_with_token_and_without_consumer_id()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setCardNumber(null);
        $this->setToken($faker->word);
        $this->setConsumerId(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_not_fail_with_token_and_with_consumer_id()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setCardNumber(null);

        $this->setToken($faker->sha256);
        $this->setConsumerId($faker->numberBetween(1, PHP_INT_MAX));


        $this->shouldNotThrow()
            ->during('getDocument');
    }

    public function it_should_not_fail_without_consumer_id()
    {
        $this->setRequestParameters();
        $this->setRememberCard(true);

        $this->shouldNotThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_not_fail_with_consumer_id()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setRememberCard(true);
        $this->setConsumerId($faker->numberBetween());

        $this->shouldNotThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_with_remember_card_and_without_customer_email()
    {
        $this->setRequestParameters();
        $this->setRememberCard(true);
        $this->setCustomerEmail(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_without_customer_email_and_with_consumer_id()
    {
        $this->setRequestParameters();
        $this->setConsumerId('12345');
        $this->setCustomerEmail(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_be_false_remember_card()
    {
        $faker = $this->getFaker();

       $this->setRememberCard($faker->randomElement(['false', false, 0]));

       $this->getRememberCard()->shouldBe(false);
    }

    public function it_should_be_true_remember_card()
    {
        $faker = $this->getFaker();

        $this->setRememberCard($faker->randomElement(['true', true, 1]));
        $this->getRememberCard()->shouldBe(true);
    }
}

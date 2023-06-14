<?php

namespace spec\SharedExamples\Genesis\API\Request\NonFinancial\TokenizationApi;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait CreditCardSharedExamples
 * @package spec\SharedExamples\Genesis\API\Request\NonFinancial\TokenizationApi
 */
trait CreditCardSharedExamples
{
    public function it_should_fail_with_invalid_card_number()
    {
        $this->setRequestParameters();
        $this->setCardNumber('a');
        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_should_contain_optional_parameters_when_set()
    {
        $this->setRequestParameters();
        $this->setOptionalRequestParameters();

        $this->getDocument()->shouldContain('card_holder');
        $this->getDocument()->shouldContain('expiration_month');
        $this->getDocument()->shouldContain('expiration_year');
    }

    public function it_should_not_contain_optional_parameters_when_unset()
    {
        $this->setRequestParameters();

        $this->setCardHolder(null);
        $this->getDocument()->shouldNotContain('card_holder');

        $this->setExpirationMonth(null);
        $this->getDocument()->shouldNotContain('expiration_month');

        $this->setExpirationYear(null);
        $this->getDocument()->shouldNotContain('expiration_year');
    }

    protected function setOptionalRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setCardHolder($faker->name());
        $this->setExpirationMonth($faker->date('m'));
        $this->setExpirationYear($faker->date('Y'));
    }
}

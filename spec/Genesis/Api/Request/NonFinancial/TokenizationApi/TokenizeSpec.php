<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\Tokenize;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\TokenizationApi\CreditCardSharedExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class TokenizeSpec extends ObjectBehavior
{
    use CreditCardSharedExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Tokenize::class);
    }

    public function it_should_contain_required_parameters()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('consumer_id');
        $this->getDocument()->shouldContain('token_type');
        $this->getDocument()->shouldContain('email');
        $this->getDocument()->shouldContain('card_number');
    }

    public function it_should_emit_scheme_tokenized_true()
    {
        $this->setRequestParameters();
        $this->setSchemeTokenized(true);

        $this->getDocument()->shouldContain('<scheme_tokenized>true</scheme_tokenized>');
    }

    public function it_should_emit_scheme_tokenized_false()
    {
        $this->setRequestParameters();
        $this->setSchemeTokenized(false);

        $this->getDocument()->shouldContain('<scheme_tokenized>false</scheme_tokenized>');
    }

    public function it_should_omit_scheme_tokenized_when_not_set()
    {
        $this->setRequestParameters();

        $this->getSchemeTokenized()->shouldBe(null);
        $this->getDocument()->shouldNotContain('scheme_tokenized');
    }

    public function it_should_place_scheme_tokenized_outside_card_data()
    {
        $this->setRequestParameters();
        $this->setSchemeTokenized(true);

        $this->getDocument()->shouldMatch(
            '/<\/card_data>\s*<scheme_tokenized>true<\/scheme_tokenized>\s*<\/tokenize_request>/'
        );
    }

    public function it_should_normalize_scheme_tokenized_to_native_bool()
    {
        foreach ([true, 'true', 'yes', 1] as $value) {
            $this->setSchemeTokenized($value);
            $this->getSchemeTokenized()->shouldBe(true);
        }

        foreach ([false, 'false', 'no', 0] as $value) {
            $this->setSchemeTokenized($value);
            $this->getSchemeTokenized()->shouldBe(false);
        }
    }

    public function it_should_throw_when_scheme_tokenized_unrecognized()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setSchemeTokenized', ['not_a_boolean']);
    }

    public function it_should_fail_without_card_number_for_every_scheme_tokenized_mode()
    {
        foreach ([true, false, null] as $mode) {
            $this->setRequestParameters();
            $this->setCardNumber(null);

            if ($mode !== null) {
                $this->setSchemeTokenized($mode);
            }

            $this->shouldThrow(ErrorParameter::class)->during('getDocument');
        }
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setConsumerId($faker->randomNumber(5));
        $this->setTokenType('uuid');
        $this->setEmail($faker->email());
        $this->setCardNumber($faker->creditCardNumber());
    }
}

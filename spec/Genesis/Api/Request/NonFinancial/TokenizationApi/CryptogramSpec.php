<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\Cryptogram;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CryptogramSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Cryptogram::class);
    }

    public function it_should_contain_required_parameters()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('consumer_id');
        $this->getDocument()->shouldContain('token_type');
        $this->getDocument()->shouldContain('email');
        $this->getDocument()->shouldContain('token');
        $this->getDocument()->shouldContain('transaction_reference');
    }

    public function it_should_throw_when_email_invalid()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setEmail', ['invalid_email']);
    }

    public function it_should_fail_without_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_without_token()
    {
        $this->setRequestParameters();
        $this->setToken(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_without_transaction_reference()
    {
        $this->setRequestParameters();
        $this->setTransactionReference(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
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

    public function it_should_fail_without_token_for_every_scheme_tokenized_mode()
    {
        foreach ([true, false, null] as $mode) {
            $this->setRequestParameters();
            $this->setToken(null);

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
        $this->setToken($faker->uuid());
        $this->setTransactionReference($faker->uuid());
    }
}

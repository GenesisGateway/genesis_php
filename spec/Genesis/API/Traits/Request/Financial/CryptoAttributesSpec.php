<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\CryptoAttributesStub;
use spec\SharedExamples\Faker;

class CryptoAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CryptoAttributesStub::class);
    }

    public function it_should_not_throw_during_set_crypto_attribute()
    {
        $this->shouldNotThrow()->during('setCrypto', ['true']);
    }

    public function it_should_set_correct_crypto_attribute_with_string_true()
    {
        $this->setCrypto('true')->getCrypto()->shouldBe(true);
    }

    public function it_should_set_correct_crypto_attribute_with_string_false()
    {
        $this->setCrypto('false')->getCrypto()->shouldBe(false);
    }

    public function it_should_set_correct_crypto_attribute_with_bool_true()
    {
        $this->setCrypto(true)->getCrypto()->shouldBe(true);
    }

    public function it_should_set_correct_crypto_attribute_with_bool_false()
    {
        $this->setCrypto(false)->getCrypto()->shouldBe(false);
    }

    public function it_should_set_correct_crypto_attribute_with_numbers()
    {
        $this->setCrypto(0)->getCrypto()->shouldBe(false);
        $this->setCrypto(1)->getCrypto()->shouldBe(true);
    }

    public function it_should_set_correct_crypto_attribute_with_string_numbers()
    {
        $this->setCrypto('0')->getCrypto()->shouldBe(false);
        $this->setCrypto('1')->getCrypto()->shouldBe(true);

    }

    public function it_should_return_always_boolean()
    {
        $this->setCrypto(Faker::getInstance()->asciify('**'));

        $this->getCrypto()->shouldBeBool();
    }
}

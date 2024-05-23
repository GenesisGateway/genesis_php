<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\IdentityDocumentsStub;

class IdentityDocumentSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(IdentityDocumentsStub::class);
    }

    public function it_should_set_doc_correctly()
    {
        $faker = \Faker\Factory::create();

        $this->addDoc(base64_encode($faker->text), $faker->mimeType);

        $this->getDocBase64Content()->shouldBe(true);
        $this->getDocMimeType()->shouldBe(true);
    }

    public function it_should_clear_docs_correctly()
    {
        $faker = \Faker\Factory::create();

        $this->addDoc(base64_encode($faker->text), $faker->mimeType);
        $this->clearDocs();

        $this->getDocBase64Content()->shouldBe(null);
        $this->getDocMimeType()->shouldBe(null);
    }
}

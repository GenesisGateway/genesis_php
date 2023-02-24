<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\IdentityDocument;

use Genesis\API\Constants\NonFinancial\KYC\IdentityDocumentMethods;
use Genesis\API\Request\NonFinancial\KYC\IdentityDocument\Upload;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class UploadSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Upload::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_required_id()
    {
        $this->setRequestParameters();
        $this->setReferenceId(null);
        $this->setTransactionUniqueId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_doc()
    {
        $this->setRequestParameters();
        $this->clearDocs();
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_too_many_docs()
    {
        $faker = \Faker\Factory::create();

        $this->addDoc(base64_encode($faker->text), $faker->mimeType);
        $this->addDoc(base64_encode($faker->text), $faker->mimeType);
        $this->addDoc(base64_encode($faker->text), $faker->mimeType);
        $this->addDoc(base64_encode($faker->text), $faker->mimeType);

        $this->shouldThrow()->during('addDoc', [base64_encode($faker->text), $faker->mimeType]);
    }

    public function it_should_fail_with_wrong_method()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setMethod', [88]);
    }

    public function it_should_have_correct_document_upload_endpoint()
    {
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/upload_document'
        );
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setMethod(IdentityDocumentMethods::BOTH);
        $this->addDoc(base64_encode($faker->text), $faker->mimeType);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            }
        );
    }
}

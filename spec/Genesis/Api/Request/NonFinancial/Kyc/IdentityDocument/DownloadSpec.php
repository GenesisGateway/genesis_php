<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\IdentityDocument;

use Genesis\Api\Request\NonFinancial\Kyc\IdentityDocument\Download;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class DownloadSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Download::class);
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
        $this->setIdentityDocumentId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_have_correct_document_download_endpoint()
    {
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/download_document'
        );
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setIdentityDocumentId($faker->numberBetween(1, PHP_INT_MAX));
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

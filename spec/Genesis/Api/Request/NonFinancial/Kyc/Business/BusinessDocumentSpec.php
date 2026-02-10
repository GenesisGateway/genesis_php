<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\Business;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request\NonFinancial\Kyc\Business\BusinessDocument;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class BusinessDocumentSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(BusinessDocument::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'business_id',
            'id'
        ]);
    }

    public function it_should_set_correct_url()
    {
        $businessId = Faker::getInstance()->numberBetween(100000, 999999);
        $id         = Faker::getInstance()->numberBetween(100000, 999999);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setBusinessId($businessId);
        $this->setId($id);

        $this->getDocument();
        $this->getApiConfig('url')->shouldBe(
            "https://staging.kyc.emerchantpay.net:443/api/v1/businesses/{$businessId}/documents/{$id}"
        );
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    protected function setRequestParameters()
    {
        $this->setBusinessId(Faker::getInstance()->numberBetween(100000, 999999));
        $this->setId(Faker::getInstance()->numberBetween(100000, 999999));
    }
}

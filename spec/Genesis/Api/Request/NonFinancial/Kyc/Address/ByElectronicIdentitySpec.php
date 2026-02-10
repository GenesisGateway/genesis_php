<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\Address;

use Genesis\Api\Request\NonFinancial\Kyc\Address\ByElectronicIdentity;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class ByElectronicIdentitySpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(ByElectronicIdentity::class);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->testMissingRequiredParameters([
            'reference_id',
            'country',
            'first_name',
            'last_name',
            'full_address',
            'zip_code'
        ]);
    }

    public function it_should_have_correct_endpoint()
    {
        $this->getApiConfig('url')
            ->shouldBe('https://staging.kyc.emerchantpay.net:443/api/v1/verifications/address/by_electronic_identity');
    }

    public function it_should_contain_email_when_set()
    {
        $this->setRequestParameters();
        $this->setEmail($this->getFaker()->email());
        $this->getDocument()->shouldContain('email');
    }

    protected function setRequestParameters()
    {
        $this->setReferenceId($this->getFaker()->uuid());
        $this->setCountry($this->getFaker()->randomElement(Country::getList()));
        $this->setFirstName($this->getFaker()->firstName());
        $this->setMiddleName($this->getFaker()->lastName());
        $this->setLastName($this->getFaker()->lastName());
        $this->setFullAddress($this->getFaker()->address());
        $this->setZipCode($this->getFaker()->postcode());
    }
}

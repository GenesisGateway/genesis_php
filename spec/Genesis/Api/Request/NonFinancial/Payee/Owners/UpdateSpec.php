<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Owners;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Constants\NonFinancial\Payee\OwnerTypes;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Owners\Update;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class UpdateSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $ownerUniqueId;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Update::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(['owner_unique_id']);
    }

    public function it_should_work_with_only_required_parameters()
    {
        $this->setOwnerUniqueId($this->getFaker()->uuid());
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setRequestParameters();

        $this->getApiConfig('url')->shouldBe(
            'https://staging.api.emerchantpay.net:443/payee/owners/' . $this->ownerUniqueId
        );
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_PATCH);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function setRequestParameters()
    {
        $this->ownerUniqueId = $this->getFaker()->uuid();
        $this->setOwnerUniqueId($this->ownerUniqueId);
        $this->setOwnerName($this->getFaker()->company());
        $this->setOwnerCountry($this->getFaker()->randomElement(Country::getList()));
        $this->setOwnerDate($this->getFaker()->date('Y-m-d'));
        $this->setOwnerNotificationUrl($this->getFaker()->url());
        $this->setOwnerRegistrationNumber($this->getFaker()->numerify('##########'));
        $this->setAddressCity($this->getFaker()->city());
        $this->setAddressStreet($this->getFaker()->streetAddress());
        $this->setAddressState($this->getFaker()->state());
        $this->setAddressCountry($this->getFaker()->randomElement(Country::getList()));
        $this->setAddressZipCode($this->getFaker()->postcode());
    }
}

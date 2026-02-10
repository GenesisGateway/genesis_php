<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\AssociatePayeeWithOwners;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class AssociatePayeeWithOwnersSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $payee_id;
    protected $owner_id;

    public function it_is_initializable()
    {
        $this->shouldHaveType(AssociatePayeeWithOwners::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(['payee_unique_id', 'owners_unique_id']);
    }

    public function it_should_fail_with_invalid_percent_ownership()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setOwnersPercentOwnership', [150.0]);
    }

    public function it_should_accept_valid_percent_ownership()
    {
        $this->setRequestParameters();
        $this->setOwnersPercentOwnership(50.5);
        $this->getOwnersPercentOwnership()->shouldBe(50.5);
    }

    public function it_should_successfully_validate_with_valid_data()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setRequestParameters();
        $this->getApiConfig('url')->shouldContain("payee/{$this->payee_id}/owners");
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_POST);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function setRequestParameters()
    {
        $this->payee_id = $this->getFaker()->uuid;
        $this->owner_id = $this->getFaker()->uuid;

        $this->setPayeeUniqueId($this->payee_id);
        $this->setOwnersUniqueId($this->owner_id);
    }
}

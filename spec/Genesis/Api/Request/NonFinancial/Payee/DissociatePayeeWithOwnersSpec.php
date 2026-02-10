<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\DissociatePayeeWithOwners;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class DissociatePayeeWithOwnersSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $payee_id;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DissociatePayeeWithOwners::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->setPayeeUniqueId($this->getFaker()->uuid);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_accept_single_owner_id()
    {
        $this->setRequestParameters();
        $ownerId = $this->getFaker()->uuid;
        $this->setOwnersUniqueIds($ownerId);
        $this->getOwnersUniqueIds()->shouldBe([$ownerId]);
    }

    public function it_should_accept_array_of_owner_ids()
    {
        $this->setRequestParameters();
        $ownerIds = [$this->getFaker()->uuid, $this->getFaker()->uuid];
        $this->setOwnersUniqueIds($ownerIds);
        $this->getOwnersUniqueIds()->shouldBe($ownerIds);
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
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_DELETE);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function setRequestParameters()
    {
        $this->payee_id = $this->getFaker()->uuid;

        $this->setPayeeUniqueId($this->payee_id);
        $this->setOwnersUniqueIds([$this->getFaker()->uuid]);
    }
}

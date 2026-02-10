<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Owners;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Constants\NonFinancial\Payee\PayeeDocumentTypes;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Owners\CreateOwnerDocument;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class CreateOwnerDocumentSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $ownerUniqueId;

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateOwnerDocument::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(['owner_unique_id', 'document_document_type', 'document_file']);
    }

    public function it_should_fail_with_invalid_document_type()
    {
        $this->setRequestParameters();
        $this->setDocumentDocumentType('invalid_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
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

        $this->getApiConfig('url')->shouldBe(
            'https://staging.api.emerchantpay.net:443/payee/owners/' . $this->ownerUniqueId . '/documents'
        );
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
        $this->ownerUniqueId = $this->getFaker()->uuid();
        $this->setOwnerUniqueId($this->ownerUniqueId);
        $this->setDocumentDocumentType($this->getFaker()->randomElement(PayeeDocumentTypes::getAll()));
        $this->setDocumentFile('data:application/pdf;base64, JVBERi0xLjQKJcfs...');
    }
}

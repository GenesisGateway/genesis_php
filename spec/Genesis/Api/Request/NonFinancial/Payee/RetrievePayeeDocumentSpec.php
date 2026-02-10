<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\RetrievePayeeDocument;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class RetrievePayeeDocumentSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $payee_id;
    protected $document_id;

    public function it_is_initializable()
    {
        $this->shouldHaveType(RetrievePayeeDocument::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(['payee_unique_id', 'document_unique_id']);
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
        $this->getApiConfig('url')->shouldContain("payee/{$this->payee_id}/documents/{$this->document_id}");
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_GET);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function setRequestParameters()
    {
        $this->payee_id    = $this->getFaker()->uuid;
        $this->document_id = $this->getFaker()->uuid;

        $this->setPayeeUniqueId($this->payee_id);
        $this->setDocumentUniqueId($this->document_id);
    }
}

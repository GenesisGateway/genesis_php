<?php

namespace spec\Genesis\Api\Request\NonFinancial\Installments;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\NonFinancial\Installments\Show;
use Genesis\Builder;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class ShowSpec extends ObjectBehavior
{
    use RequestExamples;

    private $installmentId = '12345';

    public function it_is_initializable()
    {
        $this->shouldHaveType(Show::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'installment_id'
        ]);
    }

    public function it_builds_correct_request_path()
    {
        $this->setRequestParameters();
        $this->getRequestPath()->shouldBe("installments/{$this->installmentId}");
    }

    public function it_throws_without_installment_id_set()
    {
        $this->shouldThrow()->during('getDocument');
    }

    public function it_when_installment_id_is_set()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setRequestParameters();
        $this->getApiConfig('url')->shouldBe(
            'https://staging.gate.emerchantpay.net:443/v1/installments/' . $this->installmentId
        );
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_GET);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    protected function setRequestParameters()
    {
        $this->setInstallmentId($this->installmentId);
    }
}

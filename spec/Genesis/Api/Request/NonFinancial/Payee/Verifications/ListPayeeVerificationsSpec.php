<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Verifications;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Verifications\ListPayeeVerifications;
use Genesis\Builder;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class ListPayeeVerificationsSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $payeeUniqueId;

    public function it_is_initializable()
    {
        $this->shouldHaveType(ListPayeeVerifications::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(['payee_unique_id']);
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setRequestParameters();

        $this->getApiConfig('url')->shouldBe(
            'https://staging.api.emerchantpay.net:443/payee/' . $this->payeeUniqueId . '/verifications'
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

    public function setRequestParameters()
    {
        $this->payeeUniqueId = $this->getFaker()->uuid();
        $this->setPayeeUniqueId($this->payeeUniqueId);
    }
}

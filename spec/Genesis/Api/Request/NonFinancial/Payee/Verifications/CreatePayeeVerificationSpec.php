<?php

namespace spec\Genesis\Api\Request\NonFinancial\Payee\Verifications;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Request\NonFinancial\Payee\Verifications\CreatePayeeVerification;
use Genesis\Builder;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CreatePayeeVerificationSpec extends ObjectBehavior
{
    use RequestExamples;

    protected $payeeUniqueId;

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreatePayeeVerification::class);
        $this->shouldBeAnInstanceOf(BaseRequest::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters(['payee_unique_id']);
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
            'https://staging.api.emerchantpay.net:443/payee/' . $this->payeeUniqueId . '/verifications'
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

    public function it_should_not_include_with_checks_retry_when_omitted()
    {
        $this->setRequestParameters();

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldNotContain('with_checks_retry');
    }

    public function it_should_serialize_with_checks_retry_as_true_when_enabled()
    {
        $this->setRequestParameters();
        $this->setWithChecksRetry(true);

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain('"with_checks_retry":true');
    }

    public function it_should_preserve_with_checks_retry_as_false_when_disabled()
    {
        $this->setRequestParameters();
        $this->setWithChecksRetry(false);

        $this->getDocument()->shouldContain('"with_checks_retry":false');
    }

    public function it_should_normalize_truthy_with_checks_retry_to_boolean_true()
    {
        $this->setWithChecksRetry('true');

        $this->getWithChecksRetry()->shouldBe(true);
    }

    public function setRequestParameters()
    {
        $this->payeeUniqueId = $this->getFaker()->uuid();
        $this->setPayeeUniqueId($this->payeeUniqueId);
        $this->setVerificationNotificationUrl($this->getFaker()->url());
        $this->setVerificationRedirectUrl($this->getFaker()->url());
    }
}

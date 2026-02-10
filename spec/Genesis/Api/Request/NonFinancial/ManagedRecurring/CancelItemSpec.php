<?php

namespace spec\Genesis\Api\Request\NonFinancial\ManagedRecurring;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request;
use Genesis\Api\Request\NonFinancial\ManagedRecurring\CancelItem;
use Genesis\Builder;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class CancelItemSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CancelItem::class);
    }

    public function it_should_build_correct_url()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );
        $this->setUniqueId('123456');

        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/v1/managed_recurring/items/123456');
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', Request::METHOD_DELETE);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_have_empty_document()
    {
        $this->setUniqueId(Faker::getInstance()->uuid());
        $this->getDocument()->shouldEqual('[]');
    }

    public function it_should_fail_without_unique_id()
    {
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setUniqueId(Faker::getInstance()->uuid());
    }
}

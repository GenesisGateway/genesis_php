<?php

namespace spec\Genesis\Api\Request\NonFinancial\Reconcile;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request\NonFinancial\Reconcile\Order;
use Genesis\Config;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\MissingTerminalTokenExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class OrderSpec extends ObjectBehavior
{
    use MissingTerminalTokenExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Order::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->setRequestParameters();
        $this->testMissingRequiredParameters(['order_id']);
    }

    public function it_should_validate_with_order_id()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_accept_order_id_with_max_length()
    {
        $this->setOrderId(str_repeat('a', Order::ORDER_ID_MAX_LENGTH));
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_order_id_exceeds_max_length()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setOrderId',
            [str_repeat('a', Order::ORDER_ID_MAX_LENGTH + 1)]
        );
    }

    public function it_should_contain_order_id_in_document()
    {
        $orderId = $this->getFaker()->uuid;
        $this->setOrderId($orderId);

        $this->getDocument()->shouldContain("<reconcile>");
        $this->getDocument()->shouldContain("<order_id>{$orderId}</order_id>");
    }

    public function it_should_init_proper_xml_configuration_without_smart_router()
    {
        $token = Faker::getInstance()->uuid;
        Config::setToken($token);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        Config::setForceSmartRouting(false);
        $this->setRequestParameters();

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe(
            "https://staging.gate.emerchantpay.net:443/reconcile/by_order/{$token}/"
        );
    }

    public function it_should_init_proper_xml_configuration_with_smart_router()
    {
        Config::setToken(null);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        Config::setForceSmartRouting(true);
        $this->setRequestParameters();

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe('https://staging.api.emerchantpay.net:443/reconcile/by_order');
    }

    public function it_should_form_proper_url_with_class_property_smart_router()
    {
        Config::setToken(null);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);

        $this->setRequestParameters();
        $this->setUseSmartRouter(true);

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe('https://staging.api.emerchantpay.net:443/reconcile/by_order');
    }

    protected function setRequestParameters()
    {
        $this->setOrderId($this->getFaker()->uuid);
    }
}

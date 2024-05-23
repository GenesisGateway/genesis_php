<?php

namespace spec\Genesis\Api\Request\Base;

use Genesis\Api\Constants\Endpoints;
use Genesis\Config;
use spec\Genesis\Api\Stubs\Base\Request\FinancialStub;
use spec\SharedExamples\Faker;

class FinancialSpec extends \PhpSpec\ObjectBehavior
{
    private $faker_uuid;

    private $faker_usage;

    private $faker_remote_ip;

    public function __construct()
    {
        $this->faker_uuid      = Faker::getInstance()->uuid;
        $this->faker_usage     = Faker::getInstance()->sentence;
        $this->faker_remote_ip = Faker::getInstance()->ipv4;
    }

    public function let()
    {
        $this->beAnInstanceOf(FinancialStub::class);
    }

    public function it_when_use_smart_routing_with_getter()
    {
        $this->getUseSmartRouter()->shouldBe(false);
    }

    public function it_should_not_throw_when_use_smart_routing_with_setter()
    {
        $this->shouldNotThrow()->during('setUseSmartRouter', [true]);
    }

    public function it_when_use_smart_routing_with_proper_return_value()
    {
        $this->setUseSmartRouter(true)->shouldBe($this);
    }

    public function it_when_use_smart_routing_with_proper_setter()
    {
        $this->setUseSmartRouter('on');

        $this->getUseSmartRouter()->shouldBe(true);
    }

    public function it_should_init_proper_xml_configuration_without_smart_router()
    {
        Config::setToken($this->faker_uuid);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe(
            "https://staging.gate.emerchantpay.net:443/process/{$this->faker_uuid}/"
        );
    }

    public function it_should_init_proper_xml_configuration_with_smart_router()
    {
        Config::setToken(Faker::getInstance()->uuid);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setUseSmartRouter(true);

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe("https://staging.api.emerchantpay.net:443/transactions");
    }

    public function it_should_populate_proper_base_financial_structure()
    {
        $this->setTransactionId($this->faker_uuid);
        $this->setUsage($this->faker_usage);
        $this->setRemoteIp($this->faker_remote_ip);

        $this->getDocument()->shouldContain('<payment_transaction>');
        $this->getDocument()->shouldContain('<transaction_type>transaction_type</transaction_type>');
        $this->getDocument()->shouldContain("<transaction_id>{$this->faker_uuid}</transaction_id>");
        $this->getDocument()->shouldContain("<usage>{$this->faker_usage}</usage>");
        $this->getDocument()->shouldContain("<remote_ip>{$this->faker_remote_ip}</remote_ip>");
    }

    public function it_should_populate_proper_transaction_structure()
    {
        $this->getDocument()->shouldContain('<stub>financial</stub>');
    }
}

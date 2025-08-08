<?php

namespace spec\Genesis\Api\Request\NonFinancial\Reconcile;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request\NonFinancial\Reconcile\Transaction;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\MissingTerminalTokenExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class TransactionSpec extends ObjectBehavior
{
    use MissingTerminalTokenExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->setTransactionId(null);
        $this->setArn(null);
        $this->setUniqueId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_validate_with_arn()
    {
        $this->setArn($this->getFaker()->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_validate_with_transaction_id()
    {
        $this->setTransactionId($this->getFaker()->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_validate_with_unique_id()
    {
        $this->setUniqueId($this->getFaker()->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
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
            "https://staging.gate.emerchantpay.net:443/reconcile/{$token}/"
        );
    }

    public function it_should_init_proper_xml_configuration_with_smart_router()
    {
        Config::setToken(null);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        Config::setForceSmartRouting(true);
        $this->setRequestParameters();

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe("https://staging.api.emerchantpay.net:443/reconcile");
    }

    public function it_should_form_proper_url_with_class_property_smart_router()
    {
        Config::setToken(null);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);

        $this->setRequestParameters();
        $this->setUseSmartRouter(true);

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe("https://staging.api.emerchantpay.net:443/reconcile");
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->uuid);
        $this->setArn($faker->uuid);
        $this->setUniqueId($faker->uuid);
    }
}

<?php

namespace spec\Genesis\Api\Request\Wpf;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request\Wpf\ReconcileByOrder;
use Genesis\Config;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class ReconcileByOrderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ReconcileByOrder::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setOrderId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_accept_order_id_with_max_length()
    {
        $this->setOrderId(str_repeat('a', ReconcileByOrder::ORDER_ID_MAX_LENGTH));
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_order_id_exceeds_max_length()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setOrderId',
            [str_repeat('a', ReconcileByOrder::ORDER_ID_MAX_LENGTH + 1)]
        );
    }

    public function it_should_contain_order_id_in_document()
    {
        $orderId = Faker::getInstance()->uuid;
        $this->setOrderId($orderId);

        $this->getDocument()->shouldContain('<wpf_reconcile>');
        $this->getDocument()->shouldContain("<order_id>{$orderId}</order_id>");
    }

    public function it_should_init_proper_wpf_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setRequestParameters();

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe('https://staging.wpf.emerchantpay.net:443/wpf/reconcile/by_order');
    }

    protected function setRequestParameters()
    {
        $this->setOrderId(Faker::getInstance()->uuid);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}

<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\DeliveryTimeframes;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\PreOrderPurchaseIndicators;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ReorderItemIndicators;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ShippingIndicators;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\MerchantRiskStub;
use spec\SharedExamples\Faker;

/**
 * Class MerchantRiskAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Threeds\V2
 */
class MerchantRiskAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(MerchantRiskStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('shipping_indicator');
        $this->getStructure()->shouldHaveKey('delivery_timeframe');
        $this->getStructure()->shouldHaveKey('reorder_items_indicator');
        $this->getStructure()->shouldHaveKey('pre_order_purchase_indicator');
        $this->getStructure()->shouldHaveKey('pre_order_date');
        $this->getStructure()->shouldHaveKey('gift_card');
        $this->getStructure()->shouldHaveKey('gift_card_count');
    }

    public function it_should_set_correct_shipping_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(ShippingIndicators::getAll());

        $this->setThreedsV2MerchantRiskShippingIndicator($indicator)->shouldHaveType(MerchantRiskStub::class);
        $this->getThreedsV2MerchantRiskShippingIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_delivery_timeframe()
    {
        $timeframe = Faker::getInstance()->randomElement(DeliveryTimeframes::getAll());

        $this->setThreedsV2MerchantRiskDeliveryTimeframe($timeframe)->shouldHaveType(MerchantRiskStub::class);
        $this->getThreedsV2MerchantRiskDeliveryTimeframe()->shouldBe($timeframe);
    }

    public function it_should_set_correct_reorder_items_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(ReorderItemIndicators::getAll());

        $this->setThreedsV2MerchantRiskReorderItemsIndicator($indicator)->shouldHaveType(MerchantRiskStub::class);
        $this->getThreedsV2MerchantRiskReorderItemsIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_pre_order_purchase_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(PreOrderPurchaseIndicators::getAll());

        $this->setThreedsV2MerchantRiskPreOrderPurchaseIndicator($indicator)->shouldHaveType(MerchantRiskStub::class);
        $this->getThreedsV2MerchantRiskPreOrderPurchaseIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_pre_order_date()
    {
        $dateString = Faker::getInstance()->time(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setThreedsV2MerchantRiskPreOrderDate($dateString)->shouldHaveType(MerchantRiskStub::class);
        $this->getThreedsV2MerchantRiskPreOrderDate()->shouldBeString();
        $this->getThreedsV2MerchantRiskPreOrderDate()->shouldBe($dateString);
    }

    public function it_should_fail_with_invalid_pre_order_date()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2MerchantRiskPreOrderDate',
            ['invalid']
        );
    }

    public function it_should_set_correct_gift_card()
    {
        $this->setThreedsV2MerchantRiskGiftCard('yes')->shouldHaveType(MerchantRiskStub::class);
        $this->getThreedsV2MerchantRiskGiftCard()->shouldBeBool();
        $this->getThreedsV2MerchantRiskGiftCard()->shouldBe(true);
    }

    public function it_should_set_correct_gift_card_count()
    {
        $number = (string) rand(1, 99);

        $this->setThreedsV2MerchantRiskGiftCardCount($number)->shouldHaveType(MerchantRiskStub::class);
        $this->getThreedsV2MerchantRiskGiftCardCount()->shouldBeInt();
        $this->getThreedsV2MerchantRiskGiftCardCount()->shouldBe((int) $number);
    }

    public function it_should_fail_with_invalid_gift_card_count()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2MerchantRiskGiftCardCount',
            [rand(100, PHP_INT_MAX)]
        );

        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2MerchantRiskGiftCardCount',
            [rand(-100000, -1)]
        );
    }

    public function getMatchers(): array
    {
        return array(
            'beNotEmptyArray' => function ($subject) {
                return is_array($subject) && count($subject) > 0;
            }
        );
    }
}

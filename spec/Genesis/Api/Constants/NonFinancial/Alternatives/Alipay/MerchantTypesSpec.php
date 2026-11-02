<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Alternatives\Alipay;

use Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\MerchantTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class MerchantTypesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Alternatives\Alipay
 */
class MerchantTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MerchantTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_contain_exactly_the_expected_values()
    {
        $this->getAll()->shouldBe([
            MerchantTypes::INDIVIDUAL,
            MerchantTypes::ENTERPRISE
        ]);
    }

    public function it_should_have_expected_constant_values()
    {
        $this->getAll()->shouldBe(['INDIVIDUAL', 'ENTERPRISE']);
    }
}

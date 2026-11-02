<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Alternatives\Alipay;

use Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\SiteTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class SiteTypesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Alternatives\Alipay
 */
class SiteTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SiteTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_contain_exactly_the_expected_values()
    {
        $this->getAll()->shouldBe([
            SiteTypes::WEB,
            SiteTypes::APP
        ]);
    }

    public function it_should_have_expected_constant_values()
    {
        $this->getAll()->shouldBe(['WEB', 'APP']);
    }
}

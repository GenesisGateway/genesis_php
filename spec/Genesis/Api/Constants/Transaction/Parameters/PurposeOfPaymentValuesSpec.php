<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPayment;
use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPaymentValues;
use PhpSpec\ObjectBehavior;

/**
 * Class PurposeOfPaymentValuesSpec
 *
 * @package spec\Genesis\Api\Constants\Transaction\Parameters
 */
class PurposeOfPaymentValuesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PurposeOfPaymentValues::class);
    }

    public function it_should_be_array_get_all()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_get_all()
    {
        $this->getAll()->shouldNotBeEqualTo([]);
    }

    public function it_should_map_every_value_to_a_visa_code()
    {
        $map = PurposeOfPaymentValues::getValueToCodeMap();

        foreach (PurposeOfPaymentValues::getAll() as $value) {
            if (!isset($map[$value]) || !in_array($map[$value], PurposeOfPayment::getCodes(), true)) {
                throw new \Exception('Purpose of payment value has no valid Visa code: ' . $value);
            }
        }
    }

    public function it_should_map_values_to_their_codes()
    {
        $this->getValueToCodeMap()->shouldHaveKeyWithValue(
            PurposeOfPaymentValues::BONUS_PAYMENT,
            PurposeOfPayment::ISBONU
        );
        $this->getValueToCodeMap()->shouldHaveKeyWithValue(
            PurposeOfPaymentValues::EDUCATION,
            PurposeOfPayment::ISEDUE
        );
    }
}

<?php

namespace spec\Genesis\API\Request\Financial;

use Genesis\API\Request\Financial\Refund;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class RefundSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Refund::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'reference_id'
        ]);
    }

    public function it_should_fail_when_credit_reason_indicator_1_is_invalid()
    {
        $this->shouldThrow()->during('setCreditReasonIndicator1', ['Z']);
    }

    public function it_should_fail_when_credit_reason_indicator_2_is_invalid()
    {
        $this->shouldThrow()->during('setCreditReasonIndicator2', ['Z']);
    }

    public function it_should_fail_when_ticket_change_indicator_is_invalid()
    {
        $this->shouldThrow()->during('setTicketChangeIndicator', ['Z']);
    }

    public function it_should_work_when_credit_reason_indicator_1_is_valid()
    {
        $allowed = [
            Refund::CREDIT_REASON_INDICATOR_TRANSPORT_CANCELLATION,
            Refund::CREDIT_REASON_INDICATOR_TRAVEL_TRANSPORT,
            Refund::CREDIT_REASON_INDICATOR_PARTIAL_REFUND_OR_TICKET,
            Refund::CREDIT_REASON_INDICATOR_OTHER
        ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setCreditReasonIndicator1',
                [$value]
            );
        }
    }

    public function it_should_work_when_credit_reason_indicator_2_is_valid()
    {
        $allowed = [
            Refund::CREDIT_REASON_INDICATOR_TRANSPORT_CANCELLATION,
            Refund::CREDIT_REASON_INDICATOR_TRAVEL_TRANSPORT,
            Refund::CREDIT_REASON_INDICATOR_PARTIAL_REFUND_OR_TICKET,
            Refund::CREDIT_REASON_INDICATOR_OTHER
        ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setCreditReasonIndicator2',
                [$value]
            );
        }
    }

    public function it_should_work_when_ticket_change_indicator_is_valid()
    {
        $allowed = [
            Refund::TICKET_CHANGE_INDICATOR_TO_NEW,
            Refund::TICKET_CHANGE_INDICATOR_TO_EXISTING
        ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setTicketChangeIndicator',
                [$value]
            );
        }
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));
    }
}

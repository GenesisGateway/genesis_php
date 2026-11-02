<?php

namespace spec\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\Refund\BankAccountTypeParameters;
use Genesis\Api\Constants\Transaction\Parameters\Refund\CreditReasonIndicatorParameters;
use Genesis\Api\Constants\Transaction\Parameters\Refund\TicketChangeIndicatorParameters;
use Genesis\Api\Request\Financial\AsyncRefund;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class AsyncRefundSpec extends ObjectBehavior
{
    use RequestExamples;

    private $creditIndicators = [
        CreditReasonIndicatorParameters::OTHER,
        CreditReasonIndicatorParameters::PARTIAL_REFUND_OR_TICKET,
        CreditReasonIndicatorParameters::TRANSPORT_CANCELLATION,
        CreditReasonIndicatorParameters::TRAVEL_TRANSPORT
    ];

    private $ticketIndicators = [
        TicketChangeIndicatorParameters::TO_EXISTING,
        TicketChangeIndicatorParameters::TO_NEW
    ];

    public function it_is_initializable()
    {
        $this->shouldHaveType(AsyncRefund::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'reference_id',
            'amount',
            'currency'
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

    public function it_should_fail_when_bank_account_type_is_invalid()
    {
        $this->shouldThrow()->during('setBankAccountType', ['Z']);
    }

    public function it_should_work_when_credit_reason_indicator_1_is_valid()
    {
        $allowed = $this->creditIndicators;

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setCreditReasonIndicator1',
                [$value]
            );
        }
    }

    public function it_should_work_when_credit_reason_indicator_2_is_valid()
    {
        $allowed = $this->creditIndicators;

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setCreditReasonIndicator2',
                [$value]
            );
        }
    }

    public function it_should_work_when_ticket_change_indicator_is_valid()
    {
        $allowed = $this->ticketIndicators;

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setTicketChangeIndicator',
                [$value]
            );
        }
    }

    public function it_should_not_fail_with_beneficiary_attributes()
    {
        $this->setRequestParameters();
        $this->setBeneficiaryAttributes();

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_bank_attributes()
    {
        $this->setRequestParameters();
        $this->setBankAttributes();

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_return_the_proper_beneficiary_name_attribute_value()
    {
        $this->setBeneficiaryName('name');

        $this->getBeneficiaryName()->shouldReturn('name');
    }

    public function it_should_return_the_proper_beneficiary_bank_code_attribute_value()
    {
        $this->setBeneficiaryBankCode('bank_code');

        $this->getBeneficiaryBankCode()->shouldReturn('bank_code');
    }

    public function it_should_return_the_proper_beneficiary_account_number_attribute_value()
    {
        $this->setBeneficiaryAccountNumber('account_number');

        $this->getBeneficiaryAccountNumber()->shouldReturn('account_number');
    }

    public function it_should_contain_correct_structure()
    {
        $this->setRequestParameters();
        $this->setBeneficiaryAttributes();
        $this->setBankAttributes();
        $this->setTicketAttributes();

        $attributes = [
            'async_refund',
            'transaction_id',
            'usage',
            'remote_ip',
            'reference_id',
            'amount',
            'currency',
            'travel',
            'ticket',
            'credit_reason_indicator_1',
            'credit_reason_indicator_2',
            'ticket_change_indicator',
            'beneficiary_bank_code',
            'beneficiary_name',
            'beneficiary_account_number',
            'bank',
            'bank_branch',
            'bank_account',
            'bank_account_type'
        ];

        foreach ($attributes as $attribute) {
            $this->getDocument()->shouldContain($attribute);
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

    private function setBeneficiaryAttributes()
    {
        $this->setBeneficiaryAccountNumber('beneficiary_account_number');
        $this->setBeneficiaryBankCode('beneficiary_bank_code');
        $this->setBeneficiaryName('beneficiary_name');
    }

    private function setBankAttributes()
    {
        $faker = $this->getFaker();

        $this->setBank($faker->sentence);
        $this->setBankBranch($faker->sentence);
        $this->setBankAccount($faker->uuid);
        $this->setBankAccountType($faker->randomElement(BankAccountTypeParameters::getAll()));
    }

    private function setTicketAttributes()
    {
        $faker = $this->getFaker();

        $this->setCreditReasonIndicator1(
            $faker->randomElement($this->creditIndicators)
        );
        $this->setCreditReasonIndicator2(
            $faker->randomElement($this->creditIndicators)
        );
        $this->setTicketChangeIndicator(
            $faker->randomElement($this->ticketIndicators)
        );
    }
}

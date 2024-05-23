<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\UcofAttributesStub;
use spec\SharedExamples\Faker;

class UcofAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(UcofAttributesStub::class);
    }

    public function it_should_set_credential_on_file_transaction_identifier()
    {
        $val = Faker::getInstance()->word;

        $this->setCredentialOnFileTransactionIdentifier($val);

        $this->getCredentialOnFileTransactionIdentifier()->shouldBe($val);
    }

    public function it_should_not_fail_during_unset_credential_on_file_transaction_identifier()
    {
        $this->shouldNotThrow()->during(
            'setCredentialOnFileTransactionIdentifier',
            [null]
        );
    }

    public function it_should_set_credential_on_file_settlement_date()
    {
        $this->setCredentialOnFileSettlementDate('0107');

        $this->getCredentialOnFileSettlementDate()->shouldBe('0107');
    }

    public function it_should_not_fail_during_unset_credential_on_file_settlement_date()
    {
        $this->shouldNotThrow()->during(
            'setCredentialOnFileSettlementDate',
            [null]
        );
    }

    public function it_should_have_array_structure()
    {
        $this->returnUcofAttributesStructure()->shouldBeArray();
    }
}

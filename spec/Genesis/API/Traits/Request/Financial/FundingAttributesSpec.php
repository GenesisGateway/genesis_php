<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\Funding\IdentifierTypes;
use Genesis\API\Constants\Transaction\Parameters\Funding\ReceiverAccountTypes;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class FundingAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Genesis\API\Stubs\Traits\Request\Financial\FundingAttributesStub');
    }

    public function it_should_not_fail_when_valid_funding_identifier_type()
    {
        foreach (IdentifierTypes::getAll() as $value) {
            $this->shouldNotThrow()->duringSetFundingIdentifierType($value);
        }
    }

    public function it_should_fail_when_invalid_funding_identifier_type()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->duringSetFundingIdentifierType('aaaaa');
    }

    public function it_should_not_fail_when_valid_funding_receiver_account_number_type()
    {
        foreach (ReceiverAccountTypes::getAll() as $value) {
            $this->shouldNotThrow()->duringSetFundingReceiverAccountNumberType($value);
        }
    }

    public function it_should_fail_when_invalid_funding_receiver_account_number_type()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->duringSetFundingReceiverAccountNumberType('aaaaa');
    }

    public function it_should_fail_with_three_digit_country_code()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->duringSetFundingReceiverCountry(Faker::getInstance()->countryISOAlpha3());
    }
}

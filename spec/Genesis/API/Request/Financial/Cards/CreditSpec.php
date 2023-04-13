<?php

namespace spec\Genesis\API\Request\Financial\Cards;

use Genesis\API\Request\Financial\Cards\Credit;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\Financial\Cards\CustomerIdentificationExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\SourceOfFundsAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class CreditSpec extends ObjectBehavior
{
    use RequestExamples, SourceOfFundsAttributesExamples,
        CustomerIdentificationExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Credit::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setTransactionId(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency(
            Faker::getInstance()->randomElement(
                Currency::getList()
            )
        );
        $this->setAmount(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp(Faker::getInstance()->ipv4);
        $this->setReferenceId(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));
    }
}

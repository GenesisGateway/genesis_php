<?php

namespace spec\Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Request\Financial\Cards\Credit;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\Financial\AccountOwnerAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\CustomerIdentificationExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PurposeOfPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\SourceOfFundsAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CreditSpec extends ObjectBehavior
{
    use AccountOwnerAttributesExamples;
    use CustomerIdentificationExamples;
    use PurposeOfPaymentAttributesExamples;
    use RequestExamples;
    use SourceOfFundsAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Credit::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setTransactionId(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));
        $this->setAmount(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp(Faker::getInstance()->ipv4);
        $this->setReferenceId(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));
    }
}

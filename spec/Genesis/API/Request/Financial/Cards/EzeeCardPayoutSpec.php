<?php

namespace spec\Genesis\API\Request\Financial\Cards;

use Genesis\API\Request\Financial\Cards\EzeeCardPayout;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

/**
 * Class EzeeCardPayoutSpec
 * @package spec\Genesis\API\Request\Financial\Cards
 */
class EzeeCardPayoutSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_should_be_initializable()
    {
        $this->shouldHaveType(EzeeCardPayout::class);
    }

    public function it_should_fail_with_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'reference_id'
        ]);
    }

    public function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->uuid);
        $this->setUsage($faker->asciify('*************** ***********'));
        $this->setRemoteIp($faker->ipv4);
        $this->setAmount(10);
        $this->setCurrency('EUR');
        $this->setReferenceId($faker->uuid);
    }
}

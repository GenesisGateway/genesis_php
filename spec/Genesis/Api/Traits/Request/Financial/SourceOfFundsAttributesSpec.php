<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\SourceOfFunds;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\SourceOfFundsStub;

class SourceOfFundsAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(SourceOfFundsStub::class);
    }

    public function it_should_be_array_get_source_of_funds_structure()
    {
        $this->returnSourceOfFundsStructure()->shouldBeArray();
    }

    public function it_should_contain_source_of_funds_parameter()
    {
        $this->returnSourceOfFundsStructure()->shouldHaveKey('source_of_funds');
    }

    public function it_should_fail_with_invalid_source_of_funds_paramater()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setSourceOfFunds', ['ttttt']);
    }

    public function it_should_not_fail_with_valid_source_of_funds_parameter()
    {
        $this->shouldNotThrow(InvalidArgument::class)->duringSetSourceOfFunds(
            $this->getRandomSourceOfFundsParameter()
        );
    }

    /**
     * Helper methods
     */

    protected function getRandomSourceOfFundsParameter()
    {
        $sourceOfFunds = SourceOfFunds::getAll();

        return $sourceOfFunds[array_rand($sourceOfFunds)];
    }
}

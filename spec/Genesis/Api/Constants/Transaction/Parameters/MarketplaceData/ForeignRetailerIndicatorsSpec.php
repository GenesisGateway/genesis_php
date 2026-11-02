<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\MarketplaceData;

use Genesis\Api\Constants\Transaction\Parameters\MarketplaceData\ForeignRetailerIndicators;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;

class ForeignRetailerIndicatorsSpec extends ObjectBehavior
{
    /**
     * Independent contract fixture: the only allowed foreign_retailer_indicator value
     */
    const EXPECTED_VALUES = ['F'];

    public function it_is_initializable()
    {
        $this->shouldHaveType(ForeignRetailerIndicators::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }

    public function it_should_contain_exactly_the_expected_values()
    {
        $this::getAll()->shouldContainExactlyValues(self::EXPECTED_VALUES);
    }

    public function getMatchers(): array
    {
        return [
            'containExactlyValues' => function ($subject, $expected) {
                $actual = array_values($subject);
                sort($actual);
                sort($expected);

                if ($actual !== $expected) {
                    throw new FailureException(
                        sprintf(
                            'Expected values %s, got %s',
                            json_encode($expected),
                            json_encode($actual)
                        )
                    );
                }

                return true;
            }
        ];
    }
}

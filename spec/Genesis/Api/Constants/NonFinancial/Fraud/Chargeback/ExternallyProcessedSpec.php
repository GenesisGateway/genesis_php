<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Fraud\Chargeback;

use Genesis\Api\Constants\NonFinancial\Fraud\Chargeback\ExternallyProcessed;
use PhpSpec\ObjectBehavior;

/**
 * Class ExternallyProcessedSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Fraud\Chargeback
 */
class ExternallyProcessedSpec extends ObjectBehavior
{
    public function it_should_be_initializable()
    {
        $this->shouldHaveType(ExternallyProcessed::class);
    }

    public function it_should_be_array_get_all_externally_processed()
    {
        $this->getAll()->shouldBeArray();
    }
}

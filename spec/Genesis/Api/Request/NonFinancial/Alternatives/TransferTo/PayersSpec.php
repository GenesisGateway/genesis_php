<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\TransferTo;

use Genesis\Api\Request;
use Genesis\Api\Request\NonFinancial\Alternatives\TransferTo\Payers;
use Genesis\Builder;
use PhpSpec\ObjectBehavior;

/**
 * Class PayersSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\TransferTo
 */
class PayersSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Payers::class);
    }

    public function it_should_be_get_request_used_for_transfer_to_request()
    {
        $this->getApiConfig('type')->shouldBe(Request::METHOD_GET);
    }

    public function it_should_be_builder_xml_type_for_transfer_to_request()
    {
        $this->getApiConfig('format')->shouldBe(Builder::XML);
    }
}

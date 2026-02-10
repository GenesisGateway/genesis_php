<?php

namespace spec\Genesis\Api\Request\Base\NonFinancial\BillingApi;

use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\Request\NonFinancial\BillingApi\BaseRequestStub;

class BaseRequestSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BaseRequestStub::class);
    }

    public function it_should_set_billing_statement()
    {
        $this->setBillingStatement(['STMT001', 'STMT002']);
        $this->getBillingStatement()->shouldReturn('["STMT001","STMT002"]');
    }

    public function it_should_return_empty_string_for_empty_billing_statement()
    {
        $this->setBillingStatement([]);
        $this->getBillingStatement()->shouldReturn('');
    }

    public function it_should_validate_array_max_size()
    {
        $largeArray = array_fill(0, 11, 'item');
        $this->shouldThrow(ErrorParameter::class)
            ->during('checkArrayMaxSize', [$largeArray, 10, 'test']);
    }

    public function it_should_generate_paging_parameters()
    {
        $this->setPage(2);
        $this->setPerPage(50);
        $this->getRequestPaging()->shouldContain('page: 2');
        $this->getRequestPaging()->shouldContain('perPage: 50');
    }

    public function it_should_generate_order_parameters()
    {
        $this->setOrderByDirection('desc');
        $this->setOrderByField('creationDate');
        $this->getRequestOrder()->shouldContain('byDirection: desc');
        $this->getRequestOrder()->shouldContain('byField: creationDate');
    }
}

<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

trait NeighborhoodAttributesExamples
{
    public function it_should_not_fail_when_billing_neighborhood_set()
    {
        $this->shouldNotThrow()->during('setBillingNeighborhood', ['neighborhood']);
    }

    public function it_should_not_fail_when_shipping_neighborhood_set()
    {
        $this->shouldNotThrow()->during('setShippingNeighborhood', ['neighborhood']);
    }

    public function it_should_contain_billing_neigborhood()
    {
        $neighborhood = 'billing_neigborhood';

        $this->setRequestParameters();
        $this->setBillingNeighborhood($neighborhood);

        $this->getDocument()->shouldContain("<neighborhood>$neighborhood</neighborhood>");
    }

    public function it_should_contain_shipping_neigborhood()
    {
        $neighborhood = 'shipping_neigborhood';

        $this->setRequestParameters();
        $this->setBillingNeighborhood($neighborhood);

        $this->getDocument()->shouldContain("<neighborhood>$neighborhood</neighborhood>");
    }
}

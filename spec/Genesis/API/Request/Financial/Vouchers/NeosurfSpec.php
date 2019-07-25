<?php

namespace spec\Genesis\API\Request\Financial\Vouchers;

use Genesis\API\Request\Financial\Vouchers\Neosurf;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class NeosurfSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Neosurf::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'currency',
            'billing_country',
            'voucher_number'
        ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('LT');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_voucher_number_is_invalid()
    {
        $this->setRequestParameters();
        $this->setVoucherNumber('ABC-=*1234');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setVoucherNumber('ABC1234');
        $this->setCurrency('USD');
        $this->setBillingCountry('AT');
    }
}

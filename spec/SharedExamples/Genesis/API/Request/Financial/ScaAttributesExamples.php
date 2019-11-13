<?php


namespace spec\SharedExamples\Genesis\API\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\ScaExemptions;
use Genesis\Exceptions\ErrorParameter;

/**
 * Trait ScaAttributesExamples
 * @package spec\SharedExamples\Genesis\API\Request\Financial
 */
trait ScaAttributesExamples
{
    public function it_should_fail_when_exemption_trusted_without_visa_merchant_id()
    {
        $this->setRequestParameters();
        $this->setScaExemption(ScaExemptions::EXEMPTION_TRUSTED_MERCHANT);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_when_exemption_trusted_with_visa_merchant_id()
    {
        $this->setRequestParameters();
        $this->setScaExemption(ScaExemptions::EXEMPTION_TRUSTED_MERCHANT);
        $this->setScaVisaMerchantId('12345678');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_exemption_is_not_trusted_and_no_vmid()
    {
        $this->setRequestParameters();
        $this->setScaExemption(ScaExemptions::EXEMPTION_LOW_RISK);
        $this->shouldNotThrow()->during('getDocument');
    }
}

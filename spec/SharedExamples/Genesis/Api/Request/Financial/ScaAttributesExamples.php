<?php


namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\ScaExemptions;
use Genesis\Exceptions\ErrorParameter;

/**
 * Trait ScaAttributesExamples
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait ScaAttributesExamples
{
    /**
     * Example Sca Exemption attribute value
     *
     * @var string $exemption
     */
    private $exemption      = ScaExemptions::EXEMPTION_TRUSTED_MERCHANT;

    /**
     * Example Sca Visa MerchantId attribute value
     *
     * @var int $visaMerchantId
     */
    private $visaMerchantId = 123456;

    public function it_should_not_fail_when_exemption_trusted_without_visa_merchant_id()
    {
        $this->setRequestParameters();
        $this->setScaExemption($this->exemption);
        $this->shouldNotThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_when_exemption_trusted_with_visa_merchant_id()
    {
        $this->setRequestParameters();
        $this->setScaExemption($this->exemption);
        $this->setScaVisaMerchantId($this->visaMerchantId);
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_exemption_is_not_trusted_and_no_vmid()
    {
        $this->setRequestParameters();
        $this->setScaExemption($this->exemption);
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_sca_params_structure()
    {
        $this->setRequestParameters();

        $this->setScaExemption($this->exemption);
        $this->setScaVisaMerchantId($this->visaMerchantId);

        $this->getDocument()->shouldContain(
            "\n\x20\x20<sca_params>" .
            "\n\x20\x20\x20\x20<exemption>{$this->exemption}</exemption>" .
            "\n\x20\x20\x20\x20<visa_merchant_id>{$this->visaMerchantId}</visa_merchant_id>" .
            "\n\x20\x20</sca_params>"
        );
    }
}

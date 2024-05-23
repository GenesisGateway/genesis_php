<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

/**
 * Trait FxRateAttributesExamples
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait FxRateAttributesExamples
{
    public function it_should_not_fail_with_fx_rate_id_attribute()
    {
        $this->setRequestParameters();
        $this->setFxRateId('123');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_fx_rate_id_attribute()
    {
        $this->setRequestParameters();
        $this->setFxRateId(123);
        $this->getDocument()->shouldContain('fx_rate_id');
    }
}

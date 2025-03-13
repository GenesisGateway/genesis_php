<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use spec\SharedExamples\Faker;

trait InstallmentAttributesExamples
{
    public function it_sets_installment_plan_id()
    {
        $installmentPlanId = Faker::getInstance()->randomNumber(6);
        $this->setRequestParameters();
        $this->setInstallmentPlanId($installmentPlanId);
        $this->getDocument()->shouldContain("<installment_plan_id>{$installmentPlanId}</installment_plan_id>");
    }

    public function it_sets_installment_plan_reference()
    {
        $installmentPlanReference = Faker::getInstance()->randomNumber(6);
        $this->setRequestParameters();
        $this->setInstallmentPlanReference($installmentPlanReference);
        $this->getDocument()->shouldContain("<installment_plan_reference>{$installmentPlanReference}</installment_plan_reference>");
    }

    public function it_not_contains_installment_plan_id()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotContain('<installment_plan_id>');
    }

    public function it_not_contains_installment_plan_reference()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotContain('<installment_plan_reference>');
    }
}

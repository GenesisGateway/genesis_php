<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\SourceOfFunds;

/**
 * Trait SourceOfFundsAttributesExamples
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait SourceOfFundsAttributesExamples
{
    public function it_should_have_the_proper_source_of_funds_property_value()
    {
        $this->setSourceOfFunds(SourceOfFunds::DEBIT);
        $this->getSourceOfFunds()->shouldBe(SourceOfFunds::DEBIT);
    }

    public function it_should_be_null_when_source_of_funds_is_unset()
    {
        $this->setSourceOfFunds(SourceOfFunds::CASH);
        $this->setSourceOfFunds(null);
        $this->getSourceOfFunds()->shouldBeNull();
    }

    public function it_should_return_correct_instance_from_source_of_funds_setter()
    {
        $this->setSourceOfFunds(SourceOfFunds::CASH)->shouldReturnAnInstanceOf(
            str_replace(['Spec', 'spec\\'], '', __CLASS__)
        );

        $this->setSourceOfFunds(null)->shouldReturnAnInstanceOf(
            str_replace(['Spec', 'spec\\'], '', __CLASS__)
        );
    }

    public function it_should_not_fail_with_source_of_funds_parameter()
    {
        $this->setRequestParameters();
        $this->setSourceOfFunds(SourceOfFunds::CREDIT);
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_append_the_source_of_funds_param_to_the_document_structure()
    {
        $this->setRequestParameters();
        $this->setSourceOfFunds(SourceOfFunds::DEBIT);
        $this->getDocument()->shouldContain('source_of_funds');
    }
}

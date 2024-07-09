<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna;

use Genesis\Api\Request\NonFinancial\Alternatives\Klarna\ResendInvoice;
use Genesis\Builder;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

/**
 * Class ResendInvoiceSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna
 */
class ResendInvoiceSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(ResendInvoice::class);
    }

    public function it_should_use_builder_xml()
    {
        $this->getApiConfig('format')->shouldBe(Builder::XML);
    }

    public function it_should_contain_correct_parent_node()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('resend_invoice_request');
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters(['transaction_id']);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
    }
}

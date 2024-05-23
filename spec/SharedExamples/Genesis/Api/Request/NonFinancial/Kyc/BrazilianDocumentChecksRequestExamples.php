<?php

namespace spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc;

use Genesis\Exceptions\ErrorParameter;

/**
 * Trait BrazilianDocumentChecksRequestExamples
 * @package spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc
 */
trait BrazilianDocumentChecksRequestExamples
{
    public function it_can_build_structure()
    {
        $this->setDocumentId('document_id');

        $this->getDocument()->shouldBeString();
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setDocumentId(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    /**
     * Test that request URL contains the document ID when set
     *
     * @param string $name - request name
     * @return void
     */
    protected function testUrlDocumentId($name)
    {
        $documentID = '1234567890';
        $version    = $this->getWrappedObject()->getVersion();

        $this->setDocumentId($documentID);

        $this->getApiConfig('url')->shouldContain("api/$version/$name/$documentID");
    }
}
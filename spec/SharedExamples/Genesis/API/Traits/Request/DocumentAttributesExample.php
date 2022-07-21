<?php

namespace spec\SharedExamples\Genesis\API\Traits\Request;

/**
 * Trait DocumentAttributesExample
 *
 * Used as shared example to spec document_ikd attribute
 *
 * @package spec\SharedExamples\Genesis\API\Traits\Request
 */
trait DocumentAttributesExample
{
    public function it_should_pass_with_correct_document_id()
    {
        $correctExamples = [
            'AR' => '12345678901',
            'BR' => '123456789012',
            'CL' => '12345678',
            'CO' => '12345678',
            'IN' => 'ABCDE1234A',
            'MX' => '123456789012',
            'PY' => '123456789012',
            'PE' => '12345678',
            'TR' => '12345678',
            'UY' => '12345678',
        ];

        $this->setRequestParameters();

        foreach ($correctExamples as $country => $documentId) {
            $this->setBillingCountry($country);
            $this->setDocumentId($documentId);
            $this->shouldNotThrow()->during('getDocument');
        }
    }

    public function it_should_fail_with_wrong_document_id()
    {
        $correctExamples = ['AR', 'BR', 'CL', 'CO', 'IN', 'MX', 'PY', 'PE', 'TR', 'UY'];
        $testNumbers = [
            '1234',
            'ABCD',
            '123456789101234567891012345678910',
            'ABCDEFG234567891012345678910123ZZAABBCC'
        ];

        $this->setRequestParameters();

        foreach ($correctExamples as $country) {
            $this->setBillingCountry($country);
            $this->setDocumentId($this->getFaker()->randomElement($testNumbers));
            $this->shouldThrow()->during('getDocument');
        }
    }

    public function it_should_not_fail_when_document_id_set_with_not_validated_country()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->setDocumentId('1234567890');
        $this->shouldNotThrow()->during('getDocument');
    }
}

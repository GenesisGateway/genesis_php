<?php

namespace spec\Genesis\API\Traits\Request;

use PhpSpec\ObjectBehavior;

class DocumentAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Genesis\API\Stubs\Traits\Request\DocumentAttributesStub');
    }

    public function it_should_set_document_id_correctly()
    {
        $this->shouldNotThrow()->during(
            'setDocumentId',
            ['ABCDE1234F']
        );
    }

    public function it_should_fail_when_document_id_invalid()
    {
        $invalidDocumentIds = [
            'A3CDE1234F',
            'ABCDE1D34F',
            'ABCDE1234FF',
            'ABCDE1234'
        ];

        foreach ($invalidDocumentIds as $invalidDocumentId) {
            $this->shouldThrow()->during(
                'setDocumentId',
                [$invalidDocumentId]
            );
        }
    }
}

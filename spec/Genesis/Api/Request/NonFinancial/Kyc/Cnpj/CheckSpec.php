<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\Cnpj;

use Genesis\Api\Request\NonFinancial\Kyc\Cnpj\Check;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc\BrazilianDocumentChecksRequestExamples;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc\KycRequestExamples;

class CheckSpec extends ObjectBehavior
{
    use BrazilianDocumentChecksRequestExamples;
    use KycRequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Check::class);
    }

    public function it_should_have_document_id_in_url()
    {
        $this->testUrlDocumentId('cnpj');
    }
}

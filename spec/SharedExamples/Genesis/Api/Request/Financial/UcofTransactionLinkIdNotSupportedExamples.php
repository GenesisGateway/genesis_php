<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Exceptions\ErrorParameter;

/**
 * Shared examples for requests that use UcofAttributes but do not support
 * the credential_on_file_transaction_link_id parameter
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait UcofTransactionLinkIdNotSupportedExamples
{
    public function it_should_fail_when_credential_on_file_transaction_link_id_is_set()
    {
        $this->setRequestParameters();
        $this->setCredentialOnFileTransactionLinkId('ABCDEfghij1234567890-_');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_contain_credential_on_file_transaction_link_id_node()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<credential_on_file_transaction_link_id>');
    }
}

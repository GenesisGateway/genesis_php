<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\CredentialOnFile;
use Genesis\Api\Constants\Transaction\Parameters\Recurring\Types;
use Genesis\Exceptions\InvalidArgument;

/**
 * Shared examples for requests that support
 * the credential_on_file_transaction_link_id parameter (Authorize, Sale)
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait UcofTransactionLinkIdAttributesExamples
{
    /**
     * Example Link ID value from the Gateway API docs (22 chars, mixed case)
     *
     * @var string
     */
    private $ucof_link_id_fixture = 'ABCDEfghij1234567890-_';

    /**
     * Example Ucof Transaction Identifier value used together with the Link ID
     *
     * @var string
     */
    private $ucof_link_id_transaction_identifier = 'MCC242736';

    public function it_should_set_credential_on_file_transaction_link_id_with_docs_fixture()
    {
        $this->setCredentialOnFileTransactionLinkId($this->ucof_link_id_fixture);
        $this->getCredentialOnFileTransactionLinkId()->shouldBe($this->ucof_link_id_fixture);
    }

    public function it_should_set_credential_on_file_transaction_link_id_shorter_than_max()
    {
        $this->setCredentialOnFileTransactionLinkId('aBc-123_X');
        $this->getCredentialOnFileTransactionLinkId()->shouldBe('aBc-123_X');
    }

    public function it_should_fail_when_credential_on_file_transaction_link_id_is_too_long()
    {
        $this->shouldThrow(
            new InvalidArgument('credential_on_file_transaction_link_id value must be max 22 chars long.')
        )->during('setCredentialOnFileTransactionLinkId', [str_repeat('a', 23)]);
    }

    public function it_should_clear_credential_on_file_transaction_link_id_with_null()
    {
        $this->setCredentialOnFileTransactionLinkId($this->ucof_link_id_fixture);
        $this->setCredentialOnFileTransactionLinkId(null);
        $this->getCredentialOnFileTransactionLinkId()->shouldBeNull();
    }

    public function it_should_clear_credential_on_file_transaction_link_id_with_empty_string()
    {
        $this->setCredentialOnFileTransactionLinkId($this->ucof_link_id_fixture);
        $this->setCredentialOnFileTransactionLinkId('');
        $this->getCredentialOnFileTransactionLinkId()->shouldBeNull();
    }

    public function it_should_contain_credential_on_file_transaction_link_id_in_subsequent_flow()
    {
        $this->setRequestParameters();
        $this->setRecurringType(Types::SUBSEQUENT);
        $this->setCredentialOnFileTransactionIdentifier($this->ucof_link_id_transaction_identifier);
        $this->setCredentialOnFileTransactionLinkId($this->ucof_link_id_fixture);

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain($this->getExpectedUcofLinkIdNode());
    }

    public function it_should_contain_credential_on_file_transaction_link_id_in_ucof_flow()
    {
        $this->setRequestParameters();
        $this->setCredentialOnFile(CredentialOnFile::MERCHANT_UNSCHEDULED);
        $this->setCredentialOnFileTransactionIdentifier($this->ucof_link_id_transaction_identifier);
        $this->setCredentialOnFileTransactionLinkId($this->ucof_link_id_fixture);

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain($this->getExpectedUcofLinkIdNode());
    }

    public function it_should_contain_credential_on_file_transaction_link_id_without_flow_and_identifier()
    {
        $this->setRequestParameters();
        $this->setCredentialOnFileTransactionLinkId($this->ucof_link_id_fixture);

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain($this->getExpectedUcofLinkIdNode());
    }

    public function it_should_not_contain_credential_on_file_transaction_link_id_when_not_set()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<credential_on_file_transaction_link_id>');
    }

    /**
     * Expected XML node for the Link ID fixture
     *
     * @return string
     */
    protected function getExpectedUcofLinkIdNode()
    {
        return "<credential_on_file_transaction_link_id>{$this->ucof_link_id_fixture}" .
            '</credential_on_file_transaction_link_id>';
    }
}

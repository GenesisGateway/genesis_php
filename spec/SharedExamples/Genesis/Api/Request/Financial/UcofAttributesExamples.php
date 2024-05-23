<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\CredentialOnFile;

trait UcofAttributesExamples
{
    /**
     * Example Ucof Settlement Date value
     *
     * @var string
     */
    private $settlement_date = '0107';

    /**
     * Example Ucof Transaction Identifier value
     *
     * @var string
     */
    private $transaction_idetifier = 'MCC242736';

    public function it_should_not_fail_with_ucof_attributes()
    {
        $this->setRequestParameters();
        $this->setUcofParameters();

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_ucof_attributes()
    {
        $this->setRequestParameters();
        $this->setUcofParameters();

        $this->getDocument()->shouldContain(
            "<credential_on_file_transaction_identifier>{$this->transaction_idetifier}</credential_on_file_transaction_identifier>"
        );
        $this->getDocument()->shouldContain(
            "<credential_on_file_settlement_date>{$this->settlement_date}</credential_on_file_settlement_date>"
        );
    }

    protected function setUcofParameters()
    {
        $this->setCredentialOnFileTransactionIdentifier($this->transaction_idetifier);
        $this->setCredentialOnFileSettlementDate($this->settlement_date);
    }

    protected function it_should_not_fail_with_cof_indicator_and_ucof_attributes()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during(
            'setCredentialOnFile',
            [CredentialOnFile::MERCHANT_UNSCHEDULED]
        );
        $this->setUcofParameters();

        $this->getCredentialOnFile()->shouldBe(CredentialOnFile::MERCHANT_UNSCHEDULED);
        $this->shouldNotThrow()->during('getDocument');
    }
}

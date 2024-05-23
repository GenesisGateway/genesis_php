<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\CredentialOnFile;
use spec\SharedExamples\Faker;

trait CredentialOnFileAttributesExamples
{
    public function it_should_not_fail_with_credential_on_file_attributes()
    {
        $this->setRequestParameters();
        $this->setCredentialOnFileParameters();

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_credential_on_file_attributes()
    {
        $this->setRequestParameters();

        $cofIndicator = CredentialOnFile::INITIAL_CUSTOMER_INITIATED;
        $this->setCredentialOnFile($cofIndicator);

        $this->getDocument()->shouldContain(
            "<credential_on_file>$cofIndicator</credential_on_file>"
        );
    }

    protected function setCredentialOnFileParameters()
    {
        $this->setCredentialOnFile(Faker::getInstance()->randomElement(CredentialOnFile::getAll()));
    }
}

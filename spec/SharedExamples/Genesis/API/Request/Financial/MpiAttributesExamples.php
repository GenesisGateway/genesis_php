<?php


namespace spec\SharedExamples\Genesis\API\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\MpiProtocolVersions;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeIndicators;
use Genesis\Exceptions\ErrorParameter;
use spec\SharedExamples\Faker;

/**
 * Trait MpiAttributesExamples
 * @package spec\SharedExamples\Genesis\API\Request\Financial
 */
trait MpiAttributesExamples
{
    private function setMpi3DSv1()
    {
        $this->setMpiXid('xid');
        $this->setMpiCavv('cavv');
        $this->setMpiEci('eci');
    }

    private function remove3DSv1Params()
    {
        $this->setMpiXid(null);
        $this->setMpiCavv(null);
        $this->setMpiEci(null);
    }

    private function removeNotificationParams()
    {
        $this->setNotificationUrl(null);
        $this->setReturnSuccessUrl(null);
        $this->setReturnFailureUrl(null);
    }

    private function setMpi3DSv2()
    {
        $this->setMpi3DSv1();
        $this->setMpiProtocolVersion(MpiProtocolVersions::PROTOCOL_VERSION_2);
        $this->setMpiDirectoryServerId(123456789);
    }

    public function it_should_not_fail_when_3DSv1_params_used()
    {
        $this->setRequestParameters();
        $this->removeNotificationParams();
        $this->remove3DSv1Params();

        $this->setMpi3DSv1();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_3DSv2_params_used()
    {
        $this->setRequestParameters();
        $this->removeNotificationParams();
        $this->remove3DSv1Params();

        $this->setMpi3DSv2();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_protocol_version_2_without_directory_server_id()
    {
        $this->setRequestParameters();
        $this->removeNotificationParams();

        $this->setMpi3DSv2();
        $this->setMpiDirectoryServerId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_no_eci_or_notification_url_set()
    {
        $this->setRequestParameters();
        $this->removeNotificationParams();
        $this->remove3DSv1Params();

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_contain_asc_transaction_id()
    {
        $testUuid = Faker::getInstance()->uuid();

        $this->setRequestParameters();
        $this->setMpi3DSv2();

        $this->setMpiAscTransactionId($testUuid);

        $this->getDocument()->shouldContain("<asc_transaction_id>$testUuid</asc_transaction_id>");
    }

    public function it_should_contain_threeds_challenge_indicator()
    {
        $testUuid = Faker::getInstance()->randomElement(ChallengeIndicators::getAll());

        $this->setRequestParameters();
        $this->setMpi3DSv2();

        $this->setMpiThreedsChallengeIndicator($testUuid);

        $this->getDocument()->shouldContain("<threeds_challenge_indicator>$testUuid</threeds_challenge_indicator>");
    }


}

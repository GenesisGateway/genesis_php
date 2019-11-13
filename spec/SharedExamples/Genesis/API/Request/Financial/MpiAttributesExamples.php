<?php


namespace spec\SharedExamples\Genesis\API\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\MpiProtocolVersions;

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
}

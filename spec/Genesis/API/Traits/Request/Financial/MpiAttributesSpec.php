<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\MpiProtocolVersions;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\MpiAttributesStub;

class MpiAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(MpiAttributesStub::class);
    }

    public function it_should_not_fail_when_valid_protocol_version()
    {
        foreach(MpiProtocolVersions::getAll() as $value) {
            $this->shouldNotThrow()->duringSetMpiProtocolVersion($value);
        }
    }

    public function it_should_not_fail_when_protocol_version_integer()
    {
        $this->shouldNotThrow()->duringSetMpiProtocolVersion(1);
        $this->shouldNotThrow()->duringSetMpiProtocolVersion(2);
    }

    public function it_should_fail_when_invalid_protocol_version()
    {
        $this->shouldThrow(ErrorParameter::class)
            ->duringSetMpiProtocolVersion('ttttt');
    }

    public function it_should_be_a_3DSv2_when_protocol_version_is_2()
    {
        $this->setMpiProtocolVersion(MpiProtocolVersions::PROTOCOL_VERSION_2);
        $this->getIs3DSv2()->shouldBe(true);
    }

    public function it_should_be_a_3DSv2_when_protocol_version_is_int()
    {
        $this->setMpiProtocolVersion(2);
        $this->getIs3DSv2()->shouldBe(true);
    }

    public function it_should_have_array_keys_for_3DSv1()
    {
        $this->setMpiProtocolVersion(MpiProtocolVersions::PROTOCOL_VERSION_1);
        $this->return3DSv1ParamsStructure()->shouldHaveKey('eci');
        $this->return3DSv1ParamsStructure()->shouldNotHaveKey('protocol_version');
    }

    public function it_should_have_array_keys_for_3DSv2()
    {
        $this->setMpiProtocolVersion(MpiProtocolVersions::PROTOCOL_VERSION_2);
        $this->return3DSv2ParamsStructure()->shouldHaveKey('eci');
        $this->return3DSv2ParamsStructure()->shouldHaveKey('protocol_version');
        $this->return3DSv2ParamsStructure()->shouldHaveKey('directory_server_id');
    }

    public function it_should_have_correct_params_structure_for_specific_protocol_version()
    {
        $this->setMpiProtocolVersion(MpiProtocolVersions::PROTOCOL_VERSION_2);
        $this->returnMpiParamsStructure()->shouldHaveKey('eci');
        $this->returnMpiParamsStructure()->shouldHaveKey('protocol_version');
        $this->returnMpiParamsStructure()->shouldHaveKey('directory_server_id');
    }
}

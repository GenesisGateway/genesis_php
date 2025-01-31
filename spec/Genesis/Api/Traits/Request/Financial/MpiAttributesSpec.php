<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\MpiProtocolSubVersions;
use Genesis\Api\Constants\Transaction\Parameters\MpiProtocolVersions;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeIndicators;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\MpiAttributesStub;
use spec\SharedExamples\Faker;

class MpiAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(MpiAttributesStub::class);
    }

    public function it_should_not_fail_when_valid_protocol_version()
    {
        foreach (MpiProtocolVersions::getAll() as $value) {
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

    public function it_should_have_key_acs_transaction_id_when_threeds_v2()
    {
        $this->setMpiProtocolVersion(MpiProtocolVersions::PROTOCOL_VERSION_2);
        $this->setMpiAcsTransactionId(Faker::getInstance()->uuid());
        $this->returnMpiParamsStructure()->shouldHaveKey('acs_transaction_id');
    }

    public function it_should_have_key_threeds_challenge_indicator_when_threeds_v2()
    {
        $this->setMpiProtocolVersion(MpiProtocolVersions::PROTOCOL_VERSION_2);
        $this->setMpiThreedsChallengeIndicator(Faker::getInstance()->randomElement(ChallengeIndicators::getAll()));
        $this->returnMpiParamsStructure()->shouldHaveKey('threeds_challenge_indicator');
    }

    public function it_should_not_fail_on_correct_threeds_challenge_indicator()
    {
        $this->shouldNotThrow()->during(
            'setMpiThreedsChallengeIndicator',
            [
                Faker::getInstance()->randomElement(ChallengeIndicators::getAll())
            ]
        );
    }

    public function it_should_fail_on_incorrect_threeds_challenge_indicator()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setMpiThreedsChallengeIndicator',
            [
                Faker::getInstance()->uuid()
            ]
        );
    }

    public function it_should_not_fail_with_valid_protocol_subversion()
    {
        $this->shouldNotThrow()->duringSetMpiProtocolSubVersion(
            Faker::getInstance()->randomElement(MpiProtocolSubVersions::getAll())
        );
    }

    public function it_should_not_fail_when_protocol_subversion_integer()
    {
        $this->shouldNotThrow()->duringSetMpiProtocolSubVersion(2);
    }

    public function it_should_fail_with_invalid_protocol_subversion()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->duringSetMpiProtocolSubVersion('error');
    }
}

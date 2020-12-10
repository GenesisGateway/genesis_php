<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Sdk\Interfaces;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Sdk\UiTypes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\SdkStub;
use spec\SharedExamples\Faker;

/**
 * Class SdkAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Threeds\V2
 */
class SdkAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(SdkStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('interface');
        $this->getStructure()->shouldHaveKey('ui_types');
        $this->getStructure()->shouldHaveKey('application_id');
        $this->getStructure()->shouldHaveKey('encrypted_data');
        $this->getStructure()->shouldHaveKey('ephemeral_public_key_pair');
        $this->getStructure()->shouldHaveKey('max_timeout');
        $this->getStructure()->shouldHaveKey('reference_number');
    }

    public function it_should_set_correct_interface()
    {
        $interface = Faker::getInstance()->randomElement(Interfaces::getAll());

        $this->setThreedsV2SdkInterface($interface)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkInterface()->shouldBe($interface);
    }

    public function it_should_set_correct_string_for_ui_type()
    {
        $type = Faker::getInstance()->randomElement(UiTypes::getAll());

        $this->setThreedsV2SdkUiTypes($type)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkUiTypes()->shouldBeArray();
        $this->getThreedsV2SdkUiTypes()->shouldBe([$type]);
    }

    public function it_should_set_correct_array_for_ui_types()
    {
        $types = [
            Faker::getInstance()->randomElement(UiTypes::getAll()),
            Faker::getInstance()->randomElement(UiTypes::getAll())
        ];

        $this->setThreedsV2SdkUiTypes($types)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkUiTypes()->shouldBeArray();
        $this->getThreedsV2SdkUiTypes()->shouldBe($types);
    }

    public function it_should_fail_with_invalid_ui_type()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setThreedsV2SdkUiTypes', ['invalid']);
    }

    public function it_should_fail_with_invalid_ui_types()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2SdkUiTypes',
            ['invalid', Faker::getInstance()->randomElement(UiTypes::getAll())]
        );
    }

    public function it_should_have_correct_structure_for_uid_types()
    {
        $type_1 = Faker::getInstance()->randomElement(UiTypes::getAll());
        $type_2 = Faker::getInstance()->randomElement(UiTypes::getAll());

        $this->setThreedsV2SdkUiTypes([$type_1, $type_2]);

        $this->getStructure()->shouldHaveKeyWithValue(
            'ui_types',
            [
                ['ui_type' => $type_1],
                ['ui_type' => $type_2]
            ]
        );
    }

    public function it_should_set_correct_application_id()
    {
        $appId = Faker::getInstance()->asciify(str_repeat('*', 36));

        $this->setThreedsV2SdkApplicationId($appId)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkApplicationId()->shouldBe($appId);
    }

    public function it_should_fail_with_invalid_application_id()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2SdkApplicationId',
            [Faker::getInstance()->asciify(str_repeat('*', 37))]
        );
    }

    public function it_should_set_correct_encrypted_data()
    {
        $string = Faker::getInstance()->regexify('[a-z+A-Z+0-9+_+%+]{64000}');

        $this->setThreedsV2SdkEncryptedData($string)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkEncryptedData()->shouldBe($string);
    }

    public function it_should_fail_with_invalid_encrypted_data()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2SdkEncryptedData',
            [Faker::getInstance()->regexify('[a-z+A-Z+0-9+_+%+]{64001,70000}')]
        );
    }

    public function it_should_set_correct_ephemeral_public_key_pair()
    {
        $string = Faker::getInstance()->regexify('[a-z+A-Z+0-9+_+%+]{256}');

        $this->setThreedsV2SdkEphemeralPublicKeyPair($string)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkEphemeralPublicKeyPair()->shouldBe($string);
    }

    public function it_should_fail_with_invalid_ephemeral_public_key_pair()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2SdkEphemeralPublicKeyPair',
            [Faker::getInstance()->regexify('[a-z+A-Z+0-9+_+%+]{257,1000}')]
        );
    }

    public function it_should_set_correct_max_timeout()
    {
        $timeout = (string) rand(5,PHP_INT_MAX);

        $this->setThreedsV2SdkMaxTimeout($timeout)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkMaxTimeout()->shouldBeInt();
        $this->getThreedsV2SdkMaxTimeout()->shouldBe((int) $timeout);
    }

    public function it_should_fail_with_invalid_max_timeout()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2SdkMaxTimeout',
            [rand(-1000000, 4)]
        );
    }

    public function it_should_set_correct_reference_number()
    {
        $number = Faker::getInstance()->asciify(str_repeat('*', 32));

        $this->setThreedsV2SdkReferenceNumber($number)->shouldHaveType(SdkStub::class);
        $this->getThreedsV2SdkReferenceNumber()->shouldBe($number);
    }

    public function it_should_fail_with_invalid_reference_number()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2SdkReferenceNumber',
            [Faker::getInstance()->asciify(str_repeat('*', 33))]
        );
    }

    public function getMatchers()
    {
        return array(
            'beNotEmptyArray' => function ($subject) {
                return is_array($subject) && count($subject) > 0;
            }
        );
    }
}

<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\KYC\VerificationAddressesTypes;
use Genesis\API\Constants\NonFinancial\KYC\VerificationLanguages;
use Genesis\API\Constants\NonFinancial\KYC\VerificationSupportedModes;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\KycVerificationsStub;
use spec\SharedExamples\Faker;
use Genesis\Utils\Country;

class KycVerificationsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycVerificationsStub::class);
    }

    public function it_should_set_country_correctly()
    {
        $allowed = Country::getList();

        foreach ($allowed as $country) {
            $this->shouldNotThrow()->during(
                'setCountry',
                [$country]
            );
        }
    }

    public function it_should_fail_when_country_is_invalid()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCountry',
            ['invalid_country']
        );
    }

    public function it_should_set_language_correctly()
    {
        $allowed = VerificationLanguages::getAll();

        foreach ($allowed as $lang) {
            $this->shouldNotThrow()->during(
                'setLanguage',
                [$lang]
            );
        }
    }

    public function it_should_fail_when_language_is_invalid()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setLanguage',
            ['invalid_language']
        );
    }

    public function it_should_set_verification_mode_correctly()
    {
        $allowed = VerificationSupportedModes::getAll();

        foreach ($allowed as $mode) {
            $this->shouldNotThrow()->during(
                'setVerificationMode',
                [$mode]
            );
        }
    }

    public function it_should_fail_when_verification_mode_is_invalid()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setVerificationMode',
            ['invalid_mode']
        );
    }

    public function it_should_set_address_supported_types_correctly()
    {
        $allowed = VerificationAddressesTypes::getAll();

        foreach ($allowed as $type) {
            $this->shouldNotThrow()->during(
                'setAddressSupportedTypes',
                [[$type]]
            );
        }
    }

    public function it_should_fail_when_address_supported_types_is_invalid()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setAddressSupportedTypes',
            [['invalid_address_type']]
        );
    }

    public function it_should_set_expiry_date_correctly()
    {
        $this->shouldNotThrow()->during(
            'setExpiryDate',
            [Faker::getInstance()->date('Y-m-d')]
        );

        $this->shouldNotThrow()->during(
            'setExpiryDate',
            ['']
        );
    }
}

<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\TransferTo;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\Alternatives\AccountTypes;
use Genesis\API\Constants\Transaction\Parameters\IdentificationTypes;
use Genesis\API\Constants\Transaction\Parameters\Alternatives\PurposeOfRemittances;
use Genesis\API\Request\Financial\Alternatives\TransferTo\Payout;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class PayoutSpec extends ObjectBehavior
{
    use RequestExamples, NeighborhoodAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payout::class);
    }

    public function it_should_fail_when_required_parameter_missing()
    {
        $this->setRequestParameters();
        $this->testMissingRequiredParameters([
            'payer_id',
            'currency',
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount'
        ]);
    }

    public function it_should_fail_when_not_proper_currency_value()
    {
        $this->setRequestParameters();
        $this->setCurrency('AED');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_invalid_customer_email_is_set()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCustomerEmail',
            [
                $this->getFaker()->asciify('******')
            ]
        );
    }

    public function it_should_fail_when_invalid_id_type_is_set()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setIdType',
            [
                $this->getFaker()->asciify('****')
            ]
        );
    }

    public function it_should_fail_with_invalid_account_type()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setAccountType',
            [
                $this->getFaker()->asciify('*****')
            ]
        );
    }

    public function it_should_unset_account_type()
    {
        $this->setAllParameters();

        $this->setAccountType(null)->shouldReturn($this);
        $this->getAccountType()->shouldBeNull();
    }

    public function it_should_fail_with_invalid_sender_birth_date()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setSenderDateOfBirth',
            ['Invalid Date']
        );
    }

    public function it_should_set_sender_date_of_birth_corretly_with_all_available_formats()
    {
        $dateFormat = Faker::getInstance()->randomElement(DateTimeFormat::getAll());
        $date       = Faker::getInstance()->date($dateFormat);

        $this->shouldNotThrow()->during(
            'setSenderDateOfBirth',
            [$date]
        );

        $this->getSenderDateOfBirth()->shouldBe(
            \DateTime::createFromFormat($dateFormat, $date)->format(DateTimeFormat::YYYY_MM_DD_ISO_8601)
        );
    }

    public function it_should_unset_sender_date_of_birth()
    {
        $this->setAllParameters();

        $this->setSenderDateOfBirth(null)->shouldReturn($this);
        $this->getSenderDateOfBirth()->shouldBeNull();
    }

    public function it_should_fail_with_invalid_sender_msisdn()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setSenderMsisdn',
            [
                Faker::getInstance()->asciify(
                    str_repeat(
                        '*',
                        mt_rand(1, Payout::MIN_MSISDN_LENGTH - 1)
                    )
                )
            ]
        );

        $this->shouldThrow(InvalidArgument::class)->during(
            'setSenderMsisdn',
            [
                Faker::getInstance()->asciify(
                    str_repeat(
                        '*',
                        mt_rand(Payout::MAX_MSISDN_LENGTH + 1, 100)
                    )
                )
            ]
        );
    }

    public function it_should_unset_sender_msisdn()
    {
        $this->setAllParameters();

        $this->setSenderMsisdn(null)->shouldReturn($this);
        $this->getSenderMsisdn()->shouldBeNull();
    }

    public function it_should_fail_with_invalid_msisdn()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setMsisdn',
            [
                Faker::getInstance()->asciify(
                    str_repeat(
                        '*',
                        mt_rand(1, Payout::MIN_MSISDN_LENGTH - 1)
                    )
                )
            ]
        );

        $this->shouldThrow(InvalidArgument::class)->during(
            'setSenderMsisdn',
            [
                Faker::getInstance()->asciify(
                    str_repeat(
                        '*',
                        mt_rand(Payout::MAX_MSISDN_LENGTH + 1, 100)
                    )
                )
            ]
        );
    }

    public function it_should_unset_msisdn()
    {
        $this->setAllParameters();

        $this->setMsisdn(null)->shouldReturn($this);
        $this->getMsisdn()->shouldBeNull();
    }

    public function it_should_fail_with_invalid_sender_id_type_value()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setSenderIdType',
            [
                Faker::getInstance()->asciify('****')
            ]
        );
    }

    public function it_should_unset_sender_id_type()
    {
        $this->setAllParameters();

        $this->setSenderIdType(null)->shouldReturn($this);
        $this->getSenderIdType()->shouldBeNull();
    }

    public function it_should_fail_with_invalid_purpose_of_remittance_value()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setPurposeOfRemittance',
            [Faker::getInstance()->word]
        );
    }

    public function it_should_unset_purpose_of_remittance()
    {
        $this->setAllParameters();

        $this->setPurposeOfRemittance(null)->shouldReturn($this);
        $this->getPurposeOfRemittance()->shouldBeNull();
    }

    public function it_should_be_alias_of_indian_financial_system_code()
    {
        $randomCode = Faker::getInstance()->uuid;

        $this->setIfsCode($randomCode)->shouldReturn($this);
        $this->getIndianFinancialSystemCode()->shouldBe($randomCode);
    }

    public function it_should_have_proper_structure()
    {
        $this->setAllParameters();

        $this->getDocument()->shouldContain('bank_account_number');
        $this->getDocument()->shouldContain('indian_financial_system_code');
        $this->getDocument()->shouldContain('msisdn');
        $this->getDocument()->shouldContain('branch_number');
        $this->getDocument()->shouldContain('account_type');
        $this->getDocument()->shouldContain('registered_name');
        $this->getDocument()->shouldContain('registration_number');
        $this->getDocument()->shouldContain('iban');
        $this->getDocument()->shouldContain('id_type');
        $this->getDocument()->shouldContain('id_number');
        $this->getDocument()->shouldContain('document_reference_number');
        $this->getDocument()->shouldContain('purpose_of_remittance');
        $this->getDocument()->shouldContain('sender_date_of_birth');
        $this->getDocument()->shouldContain('sender_last_name');
        $this->getDocument()->shouldContain('sender_first_name');
        $this->getDocument()->shouldContain('sender_country_iso_code');
        $this->getDocument()->shouldContain('sender_id_number');
        $this->getDocument()->shouldContain('sender_nationality_country_iso_code');
        $this->getDocument()->shouldContain('sender_address');
        $this->getDocument()->shouldContain('sender_occupation');
        $this->getDocument()->shouldContain('sender_beneficiary_relationship');
        $this->getDocument()->shouldContain('sender_postal_code');
        $this->getDocument()->shouldContain('sender_city');
        $this->getDocument()->shouldContain('sender_msisdn');
        $this->getDocument()->shouldContain('sender_gender');
        $this->getDocument()->shouldContain('sender_id_type');
        $this->getDocument()->shouldContain('sender_province_state');
        $this->getDocument()->shouldContain('sender_source_of_funds');
        $this->getDocument()->shouldContain('sender_country_of_birth_iso_code');
        $this->getDocument()->shouldContain('billing_address');
        $this->getDocument()->shouldContain('shipping_address');
    }

    public function setRequestParameters()
    {
        $this->setDefaultRequestParameters();
        $this->setCurrency('EUR');
        $this->setPayerId(12345);
    }

    public function setAllParameters()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();

        $this->setBankAccountNumber($faker->bankAccountNumber);
        $this->setIndianFinancialSystemCode(mt_rand(1, PHP_INT_MAX));
        $this->setMsisdn($faker->phoneNumber);
        $this->setBranchNumber(mt_rand(1, PHP_INT_MAX));
        $this->setAccountType(AccountTypes::CHECKING);
        $this->setRegisteredName($faker->asciify('******'));
        $this->setRegistrationNumber($faker->asciify('*******'));
        $this->setIban($faker->iban(null));
        $this->setIdType(IdentificationTypes::ALIEN_REGISTRATION);
        $this->setIdNumber(mt_rand(1, PHP_INT_MAX));
        $this->setDocumentReferenceNumber(Faker::getInstance()->asciify('****'));
        $this->setPurposeOfRemittance(PurposeOfRemittances::EDUCATION);
        $this->setSenderDateOfBirth(Faker::getInstance()->date(DateTimeFormat::YYYY_MM_DD_ISO_8601));
        $this->setSenderLastName(Faker::getInstance()->lastName);
        $this->setSenderFirstName(Faker::getInstance()->firstName);
        $this->setSenderCountryIsoCode(Faker::getInstance()->countryCode);
        $this->setSenderIdNumber(Faker::getInstance()->uuid);
        $this->setSenderNationalityCountryIsoCode(Faker::getInstance()->countryCode);
        $this->setSenderAddress(Faker::getInstance()->address);
        $this->setSenderOccupation(Faker::getInstance()->asciify('***'));
        $this->setSenderBeneficiaryRelationship(Faker::getInstance()->asciify('*****'));
        $this->setSenderPostalCode(Faker::getInstance()->postcode);
        $this->setSenderCity(Faker::getInstance()->city);
        $this->setSenderMsisdn(Faker::getInstance()->phoneNumber);
        $this->setSenderGender(Faker::getInstance()->asciify('*****'));
        $this->setSenderIdType(IdentificationTypes::ALIEN_REGISTRATION);
        $this->setSenderProvinceState(Faker::getInstance()->asciify('****'));
        $this->setSenderSourceOfFunds(Faker::getInstance()->asciify('****'));
        $this->setSenderCountryOfBirthIsoCode(Faker::getInstance()->countryCode);
        $this->setBillingFirstName($faker->firstName);
        $this->setShippingFirstName($faker->firstName);
    }
}

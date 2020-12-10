<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\RegistrationIndicators;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\ShippingAddressUsageIndicators;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\SuspiciousActivityIndicators;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\UpdateIndicators;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\CardHolderAccountStub;
use spec\SharedExamples\Faker;

/**
 * Class CardHolderAccountAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Threeds\V2
 */
class CardHolderAccountAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CardHolderAccountStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('creation_date');
        $this->getStructure()->shouldHaveKey('update_indicator');
        $this->getStructure()->shouldHaveKey('last_change_date');
        $this->getStructure()->shouldHaveKey('password_change_indicator');
        $this->getStructure()->shouldHaveKey('password_change_date');
        $this->getStructure()->shouldHaveKey('shipping_address_usage_indicator');
        $this->getStructure()->shouldHaveKey('shipping_address_date_first_used');
        $this->getStructure()->shouldHaveKey('transactions_activity_last_24_hours');
        $this->getStructure()->shouldHaveKey('transactions_activity_previous_year');
        $this->getStructure()->shouldHaveKey('provision_attempts_last_24_hours');
        $this->getStructure()->shouldHaveKey('purchases_count_last_6_months');
        $this->getStructure()->shouldHaveKey('suspicious_activity_indicator');
        $this->getStructure()->shouldHaveKey('registration_indicator');
        $this->getStructure()->shouldHaveKey('registration_date');
    }

    public function it_should_set_correct_creation_date()
    {
        $dateString = Faker::getInstance()->time(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setThreedsV2CardHolderAccountCreationDate($dateString)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountCreationDate()->shouldBeString();
        $this->getThreedsV2CardHolderAccountCreationDate()->shouldBe($dateString);
    }

    public function it_should_fail_with_invalid_creation_date()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2CardHolderAccountCreationDate',
            ['invalid']
        );
    }

    public function it_should_set_correct_update_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(UpdateIndicators::getAll());

        $this->setThreedsV2CardHolderAccountUpdateIndicator($indicator)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountUpdateIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_last_change_date()
    {
        $dateString = Faker::getInstance()->time(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setThreedsV2CardHolderAccountLastChangeDate($dateString)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountLastChangeDate()->shouldBeString();
        $this->getThreedsV2CardHolderAccountLastChangeDate()->shouldBe($dateString);
    }

    public function it_should_fail_with_invalid_last_change_date()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2CardHolderAccountLastChangeDate',
            ['invalid']
        );
    }

    public function it_should_set_correct_password_change_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(UpdateIndicators::getAll());

        $this->setThreedsV2CardHolderAccountPasswordChangeIndicator($indicator)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountPasswordChangeIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_password_change_date()
    {
        $dateString = Faker::getInstance()->time(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setThreedsV2CardHolderAccountPasswordChangeDate($dateString)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountPasswordChangeDate()->shouldBeString();
        $this->getThreedsV2CardHolderAccountPasswordChangeDate()->shouldBe($dateString);
    }

    public function it_should_fail_with_invalid_password_change_date()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2CardHolderAccountPasswordChangeDate',
            ['invlaid']
        );
    }

    public function it_should_set_correct_shipping_address_usage_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(ShippingAddressUsageIndicators::getAll());

        $this->setThreedsV2CardHolderAccountShippingAddressUsageIndicator($indicator)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountShippingAddressUsageIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_shipping_address_date_first_used()
    {
        $dateString = Faker::getInstance()->time(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setThreedsV2CardHolderAccountShippingAddressDateFirstUsed($dateString)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountShippingAddressDateFirstUsed()->shouldBeString();
        $this->getThreedsV2CardHolderAccountShippingAddressDateFirstUsed()->shouldBe($dateString);
    }

    public function it_should_fail_with_invalid_shipping_address_date_first_used()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2CardHolderAccountShippingAddressDateFirstUsed',
            ['invalid']
        );
    }

    public function it_should_set_correct_transactions_activity_last24_hours()
    {
        $number = (string) rand(-100000, PHP_INT_MAX);

        $this->setThreedsV2CardHolderAccountTransactionsActivityLast24Hours($number)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountTransactionsActivityLast24Hours()->shouldBeInt();
        $this->getThreedsV2CardHolderAccountTransactionsActivityLast24Hours()->shouldBe((int) $number);
    }

    public function it_should_set_correct_transactions_activity_previous_year()
    {
        $number = (string) rand(-100000, PHP_INT_MAX);

        $this->setThreedsV2CardHolderAccountTransactionsActivityPreviousYear($number)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountTransactionsActivityPreviousYear()->shouldBeInt();
        $this->getThreedsV2CardHolderAccountTransactionsActivityPreviousYear()->shouldBe((int) $number);
    }

    public function it_should_set_correct_provision_attempts_last24_hours()
    {
        $number = (string) rand(-100000, PHP_INT_MAX);

        $this->setThreedsV2CardHolderAccountProvisionAttemptsLast24Hours($number)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountProvisionAttemptsLast24Hours()->shouldBeInt();
        $this->getThreedsV2CardHolderAccountProvisionAttemptsLast24Hours()->shouldBe((int) $number);
    }

    public function it_should_set_correct_purchases_count_last6_months()
    {
        $number = (string) rand(-100000, PHP_INT_MAX);

        $this->setThreedsV2CardHolderAccountPurchasesCountLast6Months($number)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountPurchasesCountLast6Months()->shouldBeInt();
        $this->getThreedsV2CardHolderAccountPurchasesCountLast6Months()->shouldBe((int) $number);
    }

    public function it_should_set_correct_suspicious_activity_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(SuspiciousActivityIndicators::getAll());

        $this->setThreedsV2CardHolderAccountSuspiciousActivityIndicator($indicator)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountSuspiciousActivityIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_registration_indicator()
    {
        $indicator = Faker::getInstance()->randomElement(RegistrationIndicators::getAll());

        $this->setThreedsV2CardHolderAccountRegistrationIndicator($indicator)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountRegistrationIndicator()->shouldBe($indicator);
    }

    public function it_should_set_correct_registration_date()
    {
        $dateString = Faker::getInstance()->time(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setThreedsV2CardHolderAccountRegistrationDate($dateString)->shouldHaveType(
            CardHolderAccountStub::class
        );
        $this->getThreedsV2CardHolderAccountRegistrationDate()->shouldBeString();
        $this->getThreedsV2CardHolderAccountRegistrationDate()->shouldBe($dateString);
    }

    public function it_should_fail_with_invalid_registration_date()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setThreedsV2CardHolderAccountRegistrationDate',
            ['invalid']
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

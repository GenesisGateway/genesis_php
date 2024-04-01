<?php

namespace spec\Genesis\API\Request\WPF;

use Genesis\API\Constants\Transaction\Parameters\ScaExemptions;
use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\WPF\Create;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\Financial\AllowedZeroAmount;
use spec\SharedExamples\Genesis\API\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\FundingAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\Cards\Recurring\RecurringTypeAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\Cards\Recurring\RecurringCategoryAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\Threeds\V2\ThreedsV2AttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\AccountOwnerAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;
use Genesis\API\Constants\Payment\Methods;

class CreateSpec extends ObjectBehavior
{
    use BusinessAttributesExample, PendingPaymentAttributesExamples, AsyncAttributesExample,
        ThreedsV2AttributesExamples, AllowedZeroAmount, NeighborhoodAttributesExamples,
        RecurringCategoryAttributesExample, FundingAttributesExamples, AccountOwnerAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\WPF\Create');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldContainString('transaction_types');
    }

    public function it_should_fail_with_non_wpf_transaction_type()
    {
        $this
            ->shouldThrow('\Genesis\Exceptions\ErrorParameter')
            ->during('addTransactionType' , array(
                Types::EARTHPORT
            ));
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_set_language_parameter_ecp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this->setLanguage('en');
        $this->getApiConfig('url')->shouldContainString('wpf.e-comprocessing.net:443/en/wpf');

        $this->setLanguage('zh');
        $this->getApiConfig('url')->shouldContainString('wpf.e-comprocessing.net:443/zh/wpf');
    }

    public function it_should_set_language_parameter_emp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        $this->setLanguage('en');
        $this->getApiConfig('url')->shouldContainString('wpf.emerchantpay.net:443/en/wpf');

        $this->setLanguage('zh');
        $this->getApiConfig('url')->shouldContainString('wpf.emerchantpay.net:443/zh/wpf');
    }

    public function it_should_parse_only_two_letters_ecp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::ECOMPROCESSING
        );

        $this->setLanguage('en_US');
        $this->getApiConfig('url')->shouldContainString('wpf.e-comprocessing.net:443/en/wpf');

        $this->setLanguage('zh_ZH');
        $this->getApiConfig('url')->shouldContainString('wpf.e-comprocessing.net:443/zh/wpf');
    }

    public function it_should_parse_only_two_letters_emp_endpoint()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );

        $this->setLanguage('en_US');
        $this->getApiConfig('url')->shouldContainString('wpf.emerchantpay.net:443/en/wpf');

        $this->setLanguage('zh_ZH');
        $this->getApiConfig('url')->shouldContainString('wpf.emerchantpay.net:443/zh/wpf');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_custom_parameters()
    {
        $this->shouldThrow()
             ->during(
                 'addTransactionType',
                 [
                     Types::IDEBIT_PAYIN
                 ]
             );
    }

    public function it_should_fail_when_missing_value_for_required_custom_parameters()
    {
        $this->shouldThrow()
             ->during(
                 'addTransactionType',
                 [
                     Types::IDEBIT_PAYIN,
                     [ 'customer_account_id' => null ]
                 ]
             );
    }

    public function it_should_validate_required_custom_parameters()
    {
        $this->shouldNotThrow()->during(
            'addTransactionType',
            [
                Types::IDEBIT_PAYIN,
                [ 'customer_account_id' => 8 ]
            ]
        );
    }

    public function it_should_validate_lifetime_parameter()
    {
        $this->shouldNotThrow()->during('setLifetime', [ 5 ]);
        $this->shouldThrow()->during('setLifetime', [ 9000000 ]);
        $this->shouldThrow()->during('setLifetime', [ -5 ]);
    }

    public function it_should_fail_when_set_remember_card_and_missing_customer_email()
    {
        $this->setRequestParameters();
        $this->setRememberCard(true);
        $this->setCustomerEmail(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_set_consumer_id_and_missing_customer_email()
    {
        $this->setRequestParameters();
        $this->setConsumerId(8);
        $this->setCustomerEmail(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_invalid_reminders_channel()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('addReminder', ['test', 1]);
    }

    public function it_should_fail_when_invalid_reminders_after()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('addReminder', [
            Create::REMINDERS_CHANNEL_SMS,
            Create::MIN_ALLOWED_REMINDER_MINUTES - 1
        ]);
        $this->shouldThrow()->during('addReminder', [
            Create::REMINDERS_CHANNEL_SMS,
            Create::MAX_ALLOWED_REMINDER_DAYS * 24 * 60 + 1
        ]);
    }

    public function it_should_fail_when_adding_more_than_three_reminders()
    {
        $this->setRequestParameters();
        $this->addReminder(Create::REMINDERS_CHANNEL_EMAIL, 1);
        $this->addReminder(Create::REMINDERS_CHANNEL_EMAIL, 1);
        $this->addReminder(Create::REMINDERS_CHANNEL_EMAIL, 1);
        $this->shouldThrow()->during('addReminder', [
            Create::REMINDERS_CHANNEL_SMS,
            5
        ]);
    }

    public function it_should_clear_reminders()
    {
        $this->setRequestParameters();
        $this->addReminder(Create::REMINDERS_CHANNEL_EMAIL, 1);
        $this->addReminder(Create::REMINDERS_CHANNEL_EMAIL, 1);
        $this->addReminder(Create::REMINDERS_CHANNEL_EMAIL, 1);
        $this->clearReminders();
        $this->shouldNotThrow()->during('addReminder', [
            Create::REMINDERS_CHANNEL_SMS,
            5
        ]);
    }

    public function it_should_fail_when_reminder_value_bigger_than_default_lifetime()
    {
        $this->setRequestParameters();
        $this->setPayLater(true);
        $this->addReminder(Create::REMINDERS_CHANNEL_EMAIL, Create::DEFAULT_LIFETIME + 1);

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_valid_reminder_language()
    {
        $this->setRequestParameters();
        foreach($this->getLanguages() as $value) {
            $this->shouldNotThrow()->duringSetReminderLanguage($value);
        }
    }

    public function it_should_fail_when_invalid_reminder_language()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->duringSetReminderLanguage('qqqqq');
    }

    public function it_should_contain_sca_preference()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('<sca_preference>true</sca_preference>');
    }

    public function it_should_parse_sca_preference_to_boolean()
    {
        $this->setScaPreference('yes');

        $this->getScaPreference()->shouldBeBool();
        $this->getScaPreference()->shouldBe(true);
    }

    public function it_should_not_contain_sca_preference_with_false_value()
    {
        $this->setRequestParameters();
        $this->setScaPreference(false);

        $this->getDocument()->shouldNotContain('<sca_preference>false</sca_preference>');
    }

    public function it_should_not_fail_when_empty_description()
    {
        $this->setRequestParameters();

        $this->setDescription(null);
        $this->shouldNotThrow()->during('getDocument');

        $this->setDescription('');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_have_proper_structure_when_description_exist()
    {
        $this->setRequestParameters();

        $this->setDescription('Example Description');
        $this->getDocument()->shouldContain('<description>Example Description</description>');
    }

    public function it_should_have_proper_structure_when_description_not_exist()
    {
        $this->setRequestParameters();

        $this->setDescription('');
        $this->getDocument()->shouldNotContain('<description>');
    }

    public function it_should_allow_sca_exemption()
    {
        $this->setRequestParameters();
        $this->setScaExemption(
            Faker::getInstance()->randomElement(
                [ScaExemptions::EXEMPTION_LOW_VALUE, ScaExemptions::EXEMPTION_LOW_RISK]
            )
        )->shouldBeAnInstanceOf(Create::class);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_exemption_invalid()
    {
        $this->shouldThrow(ErrorParameter::class)
            ->during('setScaExemption', [ScaExemptions::EXEMPTION_CORPORATE_PAYMENT]);
    }

    public function it_should_have_proper_structure_when_exemption_exist()
    {
        $this->setRequestParameters();
        $exemption = Faker::getInstance()->randomElement(
            [ScaExemptions::EXEMPTION_LOW_VALUE, ScaExemptions::EXEMPTION_LOW_RISK]
        );
        $this->setScaExemption($exemption);

        $this->getDocument()->shouldContain(
            "\n\x20\x20<sca_params>" .
            "\n\x20\x20\x20\x20<exemption>$exemption</exemption>" .
            "\n\x20\x20</sca_params>"
        );
    }

    public function it_should_have_proper_structure_when_exemption_not_exist()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<sca_params>');
    }

    public function it_should_work_when_web_payment_form_id_exist()
    {
        $this->setRequestParameters();
        $this->setWebPaymentFormId(Faker::getInstance()->numberBetween(1));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_have_proper_structure_when_web_payment_form_id_exist()
    {
        $this->setRequestParameters();
        $webPaymentFormId = Faker::getInstance()->uuid;
        $this->setWebPaymentFormId($webPaymentFormId);

        $this->getDocument()->shouldContain("<web_payment_form_id>$webPaymentFormId</web_payment_form_id>");
    }

    public function it_should_have_proper_structure_when_web_payment_form_id_not_exist()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain("<web_payment_form_id>");
    }

    public function it_should_validate_paysafecard_custom_attributes()
    {
        $this->setRequestParameters();

        $this->addTransactionType(Types::PAYSAFECARD, ['customer_id' => '123456']);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_without_customer_id_when_paysafecard()
    {
        $this->setRequestParameters();

        $this->shouldThrow()->during('addTransactionType', [Types::PAYSAFECARD]);
    }

    public function it_should_fail_with_invalid_required_custom_parameters()
    {
        $this->shouldThrow(
            new ErrorParameter('Invalid value (test) for required parameter: payment_method. ' .
                'Allowed values: eps, giropay, ideal, przelewy24, safetypay, bcmc, mybank. (Transaction type: ppro)'
            )
        )->during(
            'addTransactionType',
            [
                Types::PPRO,
                [ 'payment_method' => 'test' ]
            ]
        );

        $this->shouldThrow(
            new ErrorParameter('Invalid value (bcmc, test) for required parameter: payment_method. ' .
                'Allowed values: eps, giropay, ideal, przelewy24, safetypay, bcmc, mybank. (Transaction type: ppro)'
            )
        )->during(
            'addTransactionType',
            [
                Types::PPRO,
                [ 'payment_method' => [Methods::BCMC, 'test'] ]
            ]
        );
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('USD');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage($faker->text);
        $this->setDescription('Genesis PHP Client Example Request');
        $this->setNotificationUrl($faker->url);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setReturnCancelUrl($faker->url);
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
        $this->setScaPreference(true);
        $this->addTransactionType(
            Types::SALE
        );
        $this->addTransactionType(
            Types::SALE_3D
        );
        $this->addTransactionType(
            Types::EZEEWALLET,
            array(
                'wallet_id'   => 'john@example.com',
                'wallet_pass' => 'password'
            )
        );
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty'       => function ($subject) {
                return empty($subject);
            },
            'containString' => function ($haystack, $needle) {
                return (stripos($haystack, $needle) !== false);
            }
        );
    }

    private function getLanguages()
    {
        return [
            'en', 'it', 'es', 'fr', 'de', 'ja', 'zh', 'ar', 'pt', 'tr', 'ru', 'hi', 'bg'
        ];
    }
}

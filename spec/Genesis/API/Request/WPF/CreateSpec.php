<?php

namespace spec\Genesis\API\Request\WPF;

use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\WPF\Create;
use PhpSpec\ObjectBehavior;

class CreateSpec extends ObjectBehavior
{
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
             ->during('addTransactionType', [
                 Types::CITADEL_PAYIN
             ]);
    }

    public function it_should_fail_when_missing_value_for_required_custom_parameters()
    {
        $this->shouldThrow()
             ->during('addTransactionType', [
                 Types::CITADEL_PAYIN, [ 'merchant_customer_id' => null ]
             ]);
    }

    public function it_should_validate_required_custom_parameters()
    {
        $this->addTransactionType(
            Types::CITADEL_PAYIN,
            [ 'merchant_customer_id' => 8 ]
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
        $this->addTransactionType(
            Types::PAYBYVOUCHER_SALE,
            array(
                'card_type' => 'virtual',
                'redeem_type' => 'instant'
            )
        );
    }

    public function getMatchers()
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
}

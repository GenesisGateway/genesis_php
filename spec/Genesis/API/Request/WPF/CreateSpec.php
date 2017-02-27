<?php

namespace spec\Genesis\API\Request\WPF;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Genesis\API as API;

class CreateSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\WPF\Create');
    }

    public function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldContainString('transaction_types');
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
        $this->addTransactionType('sale');
        $this->addTransactionType('sale3d');
        $this->addTransactionType(
            'ezeewallet',
            array(
                'wallet_id'   => 'john@example.com',
                'wallet_pass' => 'password'
            )
        );
        $this->addTransactionType(
            'paybyvoucher_sale',
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

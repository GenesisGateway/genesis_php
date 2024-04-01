<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\Trustly;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\IFrameTargets;
use Genesis\API\Request\Financial\Alternatives\Trustly\Sale;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use Genesis\Utils\Country;
use spec\SharedExamples\Genesis\API\Traits\Request\Financial\BirthDateAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class SaleSpec extends ObjectBehavior
{
    use RequestExamples, BirthDateAttributesExample, BusinessAttributesExample, NeighborhoodAttributesExamples;

    public $allowed_country = [
        'AT', 'BE', 'CZ', 'DK', 'EE', 'FI', 'DE', 'LV', 'LT', 'NL', 'NO', 'PL',
        'SK', 'ES', 'SE', 'GB'
    ];

    public function it_is_initializable()
    {
        $this->shouldHaveType(Sale::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'customer_email',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $faker      = $this->getFaker();
        $notAllowed = array_diff(
            array_keys(Country::$countries),
            $this->allowed_country
        );

        $randomCountry = $faker->randomElement($notAllowed);

        $this->setRequestParameters();
        $this->setBillingCountry($randomCountry);

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_allowed_billing_country_parameter_is_pass()
    {
        $faker         = $this->getFaker();
        $randomCountry = $faker->randomElement($this->allowed_country);

        $this->setRequestParameters();
        $this->setBillingCountry($randomCountry);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_customer_email_parameter()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerEmail', ['']);
    }

    public function it_should_fail_with_invalid_return_success_url_target_value()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setReturnSuccessUrlTarget',
            ['invalid']
        );
    }

    public function it_should_unset_return_success_url_target()
    {
        $this->setRequestParameters();

        $this->setReturnSuccessUrlTarget(null)->shouldReturn($this);
        $this->getReturnSuccessUrlTarget()->shouldBeNull();
    }

    public function it_should_have_correct_request_structure()
    {
        $this->setRequestParameters();

        $parameters = [
            'transaction_type',
            'transaction_id',
            'usage',
            'remote_ip',
            'return_success_url',
            'return_failure_url',
            'return_success_url_target',
            'amount',
            'currency',
            'customer_email',
            'customer_phone',
            'user_id',
            'birth_date',
            'billing_address',
            'shipping_address'
        ];

        foreach ($parameters as $parameter) {
            $this->getDocument()->shouldContain("<$parameter>");
        }
    }

    public function it_should_not_contain_business_attributes_if_not_set()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<business_attributes>');
    }

    public function it_should_contain_business_attributes_if_set()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setBusinessEventStartDate($faker->date());
        $this->setBusinessEventEndDate($faker->date());

        $this->getDocument()->shouldContain('<business_attributes>');
        $this->getDocument()->shouldContain('<event_start_date>');
        $this->getDocument()->shouldContain('<event_end_date>');
    }

    protected function setRequestParameters()
    {
        $faker         = $this->getFaker();
        $randomCountry = $faker->randomElement($this->allowed_country);

        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry($randomCountry);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setUserId($faker->uuid);
        $this->setReturnSuccessUrlTarget(IFrameTargets::SELF);
        $this->setBirthDate(Faker::getInstance()->date(DateTimeFormat::DD_MM_YYYY_L_HYPHENS));
        $this->setShippingCountry($faker->countryCode);
    }
}

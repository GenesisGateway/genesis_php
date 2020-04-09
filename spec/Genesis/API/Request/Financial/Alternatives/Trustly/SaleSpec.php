<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\Trustly;

use Genesis\API\Request\Financial\Alternatives\Trustly\Sale;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use Genesis\Utils\Country;

class SaleSpec extends ObjectBehavior
{
    use RequestExamples;

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
            'amount',
            'currency',
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
        $this->shouldThrow()->during('setCustomerEmail', [ '' ]);
    }

    protected function setRequestParameters()
    {
        $faker         = $this->getFaker();
        $randomCountry = $faker->randomElement($this->allowed_country);

        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry($randomCountry);
    }
}

<?php

namespace spec\Genesis\API\Request\Financial\Vouchers;

use Genesis\API\Request\Financial\Vouchers\Paysafecard;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class PaysafecardSpec extends ObjectBehavior
{
    use RequestExamples, NeighborhoodAttributesExamples;

    private $allowedCountries = [
        'AU', 'AT', 'BE', 'BG', 'CA', 'HR', 'CY', 'CZ', 'DK', 'FI', 'FR',
        'GE', 'DE', 'GI', 'GR', 'HU', 'IS', 'IE', 'IT', 'KW', 'LV', 'LI',
        'LT', 'LU', 'MT', 'MX', 'MD', 'ME', 'NL', 'NZ', 'NO', 'PY', 'PE',
        'PL', 'PT', 'RO', 'SA', 'SK', 'SI', 'ES', 'SE', 'CH', 'TR', 'AE',
        'GB', 'US', 'UY'
    ];

    public function it_is_initializable()
    {
        $this->shouldHaveType(Paysafecard::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'billing_country',
            'customer_id'
        ]);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerEmail', ['']);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $faker      = $this->getFaker();
        $notAllowed = array_diff(
            array_keys(Country::$countries),
            $this->allowedCountries
        );
        $randomCountry = $faker->randomElement($notAllowed);
        $this->setRequestParameters();
        $this->setBillingCountry($randomCountry);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_allowed_billing_country_parameter()
    {
        $faker         = $this->getFaker();
        $randomCountry = $faker->randomElement($this->allowedCountries);
        $this->setRequestParameters();
        $this->setBillingCountry($randomCountry);
        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('USD');
        $this->setBillingCountry('US');
        $this->setCustomerId('customer_id');
    }
}

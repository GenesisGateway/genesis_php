<?php

namespace spec\Genesis\API\Request\Financial\Alternatives;

use Genesis\API\Request\Financial\Alternatives\Sofort;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class SofortSpec extends ObjectBehavior
{
    use RequestExamples;

    public $allowed_country = [
        'AT', 'BE', 'DE', 'ES', 'IT', 'NL', 'CH', 'PL'
    ];


    public function it_is_initializable()
    {
        $this->shouldHaveType(Sofort::class);
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

    public function it_should_not_fail_with_allowed_billing_country_parameter()
    {
        $faker         = $this->getFaker();
        $randomCountry = $faker->randomElement($this->allowed_country);

        $this->setRequestParameters();
        $this->setBillingCountry($randomCountry);

        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency(
            $this->getFaker()->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setBillingCountry('DE');
    }
}

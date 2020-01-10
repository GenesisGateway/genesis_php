<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

use Genesis\Utils\Country;

/**
 * Trait SupportedCountryCodesExample
 * @package spec\SharedExamples\Genesis\API\Request\Financial
 */
trait SupportedCountryCodesExample
{
    public function it_should_not_fail_with_proper_country()
    {
        $this->setRequestParameters();
        $countries = $this->getExpectedValidCountryCodes();

        foreach ($countries as $country) {
            $this->setBillingCountry($country);

            $this->shouldNotThrow()->during('getDocument');
        }
    }

    public function it_should_fail_with_invalid_country_code()
    {
        $country = $this->getUnsupportedCountryCode();

        $this->setRequestParameters();
        $this->setBillingCountry($country);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $countries = $this->getExpectedValidCountryCodes();

        $this->setDefaultRequestParameters();

        $this->setCurrency('USD');
        $this->setConsumerReference('1234');
        $this->setNationalId('1234');
        $this->setBillingCountry($countries[array_rand($countries)]);
    }

    private function getUnsupportedCountryCode()
    {
        $availableCountries   = array_keys(Country::$countries);
        $supportedCountries   = $this->getExpectedValidCountryCodes();
        $unsupportedCountries = array_diff($availableCountries, $supportedCountries);

        return $unsupportedCountries[array_rand($unsupportedCountries)];
    }
}

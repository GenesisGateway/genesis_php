<?php

namespace spec\Genesis\API\Request\Financial\Vouchers;

use Genesis\API\Request\Financial\Vouchers\Neosurf;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class NeosurfSpec extends ObjectBehavior
{
    use RequestExamples;

    private $allowedCountries = [
        'AT', 'AU', 'BE', 'BF', 'BI', 'BJ', 'CA', 'CD', 'CF', 'CG', 'CH', 'CI', 'CM', 'CO',
        'CV', 'CY', 'DE', 'DK', 'DZ', 'ES', 'FR', 'GA', 'GB', 'GH', 'GM', 'GN', 'GQ', 'GW',
        'HK', 'IE', 'IT', 'KE', 'LU', 'MA', 'ML', 'MR', 'MW', 'MZ', 'NE', 'NG', 'NL', 'NO',
        'NZ', 'PL', 'PT', 'RO', 'RS', 'RU', 'RW', 'SE', 'SL', 'SN', 'ST', 'TD', 'TG', 'TN', 'TR',
        'TZ', 'UG', 'ZM', 'ZW'
    ];

    private $allowedCurrencies = [
        'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'IDR', 'ILS',
        'INR', 'JPY', 'KRW', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TRY',
        'USD', 'XOF', 'ZAR'
    ];

    public function it_is_initializable()
    {
        $this->shouldHaveType(Neosurf::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'currency',
            'billing_country',
            'voucher_number'
        ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('LT');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_voucher_number_is_invalid()
    {
        $this->setRequestParameters();
        $this->setVoucherNumber('ABC-=*1234');
        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('YER');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_with_allowed_billing_country()
    {
        $this->setRequestParameters();
        $this->setBillingCountry(Faker::getInstance()->randomElement($this->allowedCountries));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_allowed_currency()
    {
        $this->setRequestParameters();
        $this->setCurrency(Faker::getInstance()->randomElement($this->allowedCurrencies));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_empty_return_urls()
    {
        $this->setRequestParameters();
        $this->setReturnSuccessUrl('');
        $this->setReturnFailureUrl('');

        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setVoucherNumber('ABC1234');
        $this->setCurrency('USD');
        $this->setBillingCountry('AT');
    }
}

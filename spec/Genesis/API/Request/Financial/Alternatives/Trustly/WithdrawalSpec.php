<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\Trustly;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Request\Financial\Alternatives\Trustly\Withdrawal;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class WithdrawalSpec extends ObjectBehavior
{
    use RequestExamples;

    public $allowed_country = [
        'AT', 'BG', 'BE', 'HR', 'CZ', 'CY', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IT', 'IE', 'LT', 'LV',
        'LU', 'MT', 'NO',  'NL', 'PT', 'PL', 'RO', 'SK', 'SI', 'SE', 'ES', 'GB'
    ];

    public function it_is_initializable()
    {
        $this->shouldHaveType(Withdrawal::class);
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
            'birth_date',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('JP');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_customer_email_parameter()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerEmail', [ '' ]);
    }

    public function it_should_not_fail_when_allowed_billing_country_parameter_is_pass()
    {
        $faker         = $this->getFaker();
        $randomCountry = $faker->randomElement($this->allowed_country);

        $this->setRequestParameters();
        $this->setBillingCountry($randomCountry);

        $this->shouldNotThrow()->during('getDocument');
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
            'amount',
            'currency',
            'customer_email',
            'customer_phone',
            'birth_date',
            'billing_address',
            'shipping_address'
        ];

        foreach ($parameters as $parameter) {
            $this->getDocument()->shouldContain('<' . $parameter . '>');
        }
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setBirthDate(Faker::getInstance()->date(DateTimeFormat::DD_MM_YYYY_L_HYPHENS));
        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
        $this->setCustomerPhone(Faker::getInstance()->phoneNumber);
        $this->setShippingCountry(Faker::getInstance()->countryCode);
    }
}

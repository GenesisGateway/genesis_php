<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives;

use Genesis\Api\Request\Financial\Alternatives\Sofort;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class SofortSpec extends ObjectBehavior
{
    use AsyncAttributesExample;
    use NeighborhoodAttributesExamples;
    use PendingPaymentAttributesExamples;
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

    public function it_should_not_fail_with_allowed_billing_country_parameter()
    {
        $faker         = $this->getFaker();
        $randomCountry = $faker->randomElement($this->allowed_country);

        $this->setRequestParameters();
        $this->setBillingCountry($randomCountry);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_be_alias_to_bic()
    {
        $bic = Faker::getInstance()->swiftBicNumber;

        $this->setCustomerBankId($bic)->shouldReturn($this);
        $this->getBic()->shouldBe($bic);
    }

    public function it_should_be_alias_to_iban()
    {
        $iban = Faker::getInstance()->iban('UK');

        $this->setBankAccountNumber($iban)->shouldReturn($this);
        $this->getIban()->shouldBe($iban);
    }

    public function it_should_have_correct_structure()
    {
        $this->setRequestParameters();

        $parameters = [
            'transaction_type',
            'transaction_id',
            'usage',
            'remote_ip',
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'customer_email',
            'customer_phone',
            'bic',
            'iban',
            'billing_address',
            'shipping_address',
        ];

        foreach($parameters as $parameter) {
            $this->getDocument()->shouldContain("<$parameter>");
        }
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
        $this->setBic(Faker::getInstance()->swiftBicNumber);
        $this->setIban(Faker::getInstance()->iban('UK'));
        $this->setCustomerPhone(Faker::getInstance()->phoneNumber);
        $this->setShippingCountry(Faker::getInstance()->countryCode);
    }
}

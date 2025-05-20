<?php

namespace spec\Genesis\Api\Request\Financial\Cards\Recurring;

use Genesis\Api\Request\Financial\Cards\Recurring\RecurringSale;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\MotoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class RecurringSaleSpec extends ObjectBehavior
{
    use BusinessAttributesExample;
    use RequestExamples;
    use MotoAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(RecurringSale::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'reference_id',
            'amount'
        ]);
    }

    public function it_should_not_fail_with_currency_attribute()
    {
        $this->setRequestParameters();
        $this->setCurrency(Faker::getInstance()->randomElement(Currency::getList()));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_invalid_currency_param()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCurrency',
            ['xxx']
        );
    }

    public function it_should_transform_amount_with_currency_param()
    {
        $this->setRequestParameters();
        $this->setAmount('5.00');
        $this->setCurrency('EUR');

        $this->getDocument()->shouldContain('<amount>500</amount>');
    }

    public function it_should_not_transform_amount_without_currency_param()
    {
        $this->setRequestParameters();
        $this->setAmount('5000');

        $this->getDocument()->shouldContain('<amount>5000</amount>');
    }

    public function it_should_not_contain_currency_param_in_request()
    {
        $this->setRequestParameters();
        $this->setCurrency('EUR');

        $this->getDocument()->shouldNotContain('<currency>EUR</currency>');
    }

    public function it_should_contain_moto_attribute()
    {
        $this->setRequestParameters();
        $this->setMoto('yes');

        $this->getDocument()->shouldContain('<moto>true</moto>');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));
    }
}

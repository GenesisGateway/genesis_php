<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\Business;

use Genesis\Api\Request\NonFinancial\Kyc\Business\CreateBusiness;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class CreateBusinessSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateBusiness::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'registration_number',
            'country'
        ]);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_country_not_valid()
    {
        $this->setRequestParameters();
        $this->setCountry('XX');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = Faker::getInstance();

        $this->setRegistrationNumber($faker->numberBetween(100000, 999999));
        $this->setCountry($faker->randomElement(Country::getList()));
        $this->setName($faker->company);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}

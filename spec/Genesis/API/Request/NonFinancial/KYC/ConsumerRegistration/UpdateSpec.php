<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration;

use Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration\Update;
use PhpSpec\ObjectBehavior;

class UpdateSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Update::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setReferenceId(null);
        $this->shouldThrow()->during('getDocument');

        $this->setRequestParameters();
        $this->setProfileCurrentStatus(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setProfileCurrentStatus(
            \Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration\Update::PROFILE_CURRENT_STATUS_DENIED
        );
        $this->setStatusReason($faker->text(50));
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}

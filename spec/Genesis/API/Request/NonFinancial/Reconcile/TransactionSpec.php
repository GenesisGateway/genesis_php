<?php

namespace spec\Genesis\API\Request\Reconcile;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionSpec extends ObjectBehavior
{
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();

        $this->faker->addProvider(new \Faker\Provider\Uuid($this->faker));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Reconcile\Transaction');
    }

    public function it_should_validate_with_arn()
    {
        $this->setArn($this->faker->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_validate_with_transaction_id()
    {
        $this->setTransactionId($this->faker->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_validate_with_unique_id()
    {
        $this->setUniqueId($this->faker->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setArn(null);
        $this->setTransactionId(null);
        $this->setUniqueId(null);

        $this->shouldThrow()->during('getDocument');
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

<?php

namespace spec\SharedExamples\Genesis\Api\Request\NonFinancial\Fraud;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait RequestExamples
 * @package spec\SharedExamples\Genesis\Api\Request\NonFinancial\Fraud;
 */
trait TransactionExample
{
    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'arn'
        ]);
    }

    public function it_should_throw_when_arn_and_original_transaction_unique_id_are_set()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setOriginalTransactionUniqueId($faker->uuid);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_throw_when_original_transaction_unique_id_is_set()
    {
        $faker = $this->getFaker();

        $this->setOriginalTransactionUniqueId($faker->uuid);

        $this->shouldNotThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_throw_when_arn_is_set()
    {
        $faker = $this->getFaker();

        $this->setArn($faker->uuid);

        $this->shouldNotThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_throw_when_mode_is_set()
    {
        $this->setRequestParameters();

        $this->shouldNotThrow(InvalidArgument::class)->during('setMode', ['list']);
    }

    public function it_should_throw_when_invalid_mode_is_set()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setMode', ['invalid_value']);
    }

    public function it_should_not_throw_with_empty_mode_parameter()
    {
        $this->setRequestParameters();

        $this->shouldNotThrow(InvalidArgument::class)->during('setMode', ['']);
        $this->shouldNotThrow(InvalidArgument::class)->during('setMode', [null]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setArn($faker->uuid);
    }
}

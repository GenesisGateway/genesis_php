<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\MarketplaceDataAttributesStub;

class MarketplaceDataAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(MarketplaceDataAttributesStub::class);
    }

    public function it_should_accept_valid_foreign_retailer_indicator()
    {
        $this->shouldNotThrow()->during('setForeignRetailerIndicator', ['F']);
        $this->getForeignRetailerIndicator()->shouldBe('F');
    }

    public function it_should_fail_with_invalid_foreign_retailer_indicator_values()
    {
        $stub = $this->getWrappedObject();

        foreach (['f', '', 'X', 'FF', true] as $value) {
            $thrown = null;

            try {
                $stub->setForeignRetailerIndicator($value);
            } catch (InvalidArgument $exception) {
                $thrown = $exception;
            }

            $printable = var_export($value, true);

            if ($thrown === null) {
                throw new FailureException(
                    "Expected InvalidArgument for foreign_retailer_indicator value {$printable}"
                );
            }

            if (
                strpos($thrown->getMessage(), 'foreign_retailer_indicator') === false ||
                strpos($thrown->getMessage(), 'Allowed values are F') === false
            ) {
                throw new FailureException(
                    "Unexpected message for foreign_retailer_indicator value {$printable}: " .
                    $thrown->getMessage()
                );
            }
        }
    }

    public function it_should_keep_stored_indicator_when_invalid_value_is_rejected()
    {
        $this->setForeignRetailerIndicator('F');

        $this->shouldThrow(InvalidArgument::class)->during('setForeignRetailerIndicator', ['X']);
        $this->getForeignRetailerIndicator()->shouldBe('F');
    }

    public function it_should_keep_null_indicator_when_invalid_value_is_rejected()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setForeignRetailerIndicator', ['f']);
        $this->getForeignRetailerIndicator()->shouldBeNull();
    }

    public function it_should_clear_indicator_with_null()
    {
        $this->setForeignRetailerIndicator('F');
        $this->setForeignRetailerIndicator(null);

        $this->getForeignRetailerIndicator()->shouldBeNull();
    }

    public function it_should_fail_with_negative_foreign_retailer_transaction_amount()
    {
        $this->shouldThrow(
            new InvalidArgument(
                'Unsupported value -0.01 for parameter foreign_retailer_transaction_amount. ' .
                'Please check the documentation for more information.'
            )
        )->during('setForeignRetailerTransactionAmount', ['-0.01']);
    }

    public function it_should_fail_with_non_numeric_foreign_retailer_transaction_amount()
    {
        $this->shouldThrow(
            new InvalidArgument(
                'Unsupported value abc for parameter foreign_retailer_transaction_amount. ' .
                'Please check the documentation for more information.'
            )
        )->during('setForeignRetailerTransactionAmount', ['abc']);
    }

    public function it_should_keep_stored_amount_when_invalid_value_is_rejected()
    {
        $this->setForeignRetailerTransactionAmount('5.00');

        $this->shouldThrow(InvalidArgument::class)->during('setForeignRetailerTransactionAmount', ['10,50']);
        $this->getForeignRetailerTransactionAmount()->shouldBe('5.00');
    }

    public function it_should_keep_null_amount_when_invalid_value_is_rejected()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setForeignRetailerTransactionAmount', ['']);
        $this->getForeignRetailerTransactionAmount()->shouldBeNull();
    }

    public function it_should_accept_zero_foreign_retailer_transaction_amount()
    {
        $this->shouldNotThrow()->during('setForeignRetailerTransactionAmount', ['0']);
        $this->getForeignRetailerTransactionAmount()->shouldBe('0');
    }

    public function it_should_clear_amount_with_null()
    {
        $this->setForeignRetailerTransactionAmount('5.00');
        $this->setForeignRetailerTransactionAmount(null);

        $this->getForeignRetailerTransactionAmount()->shouldBeNull();
    }

    public function it_should_return_null_getters_when_unset()
    {
        $this->getForeignRetailerIndicator()->shouldBeNull();
        $this->getForeignRetailerTransactionAmount()->shouldBeNull();
    }

    public function it_should_return_latest_amount_after_second_set()
    {
        $this->setForeignRetailerTransactionAmount('5.00');
        $this->setForeignRetailerTransactionAmount('7.25');

        $this->getForeignRetailerTransactionAmount()->shouldBe('7.25');
    }

    public function it_should_return_latest_indicator_after_second_set()
    {
        $this->setForeignRetailerIndicator(null);
        $this->setForeignRetailerIndicator('F');

        $this->getForeignRetailerIndicator()->shouldBe('F');
    }

    public function it_should_store_trimmed_major_unit_amount()
    {
        $this->setCurrency('EUR');
        $this->setForeignRetailerTransactionAmount(' 10.50 ');

        $this->getForeignRetailerTransactionAmount()->shouldBe('10.50');
    }

    public function it_should_return_same_instance_from_indicator_setter()
    {
        $this->setForeignRetailerIndicator('F')->shouldBe($this->getWrappedObject());
        $this->setForeignRetailerIndicator(null)->shouldBe($this->getWrappedObject());
    }

    public function it_should_return_same_instance_from_amount_setter()
    {
        $this->setForeignRetailerTransactionAmount('5.00')->shouldBe($this->getWrappedObject());
        $this->setForeignRetailerTransactionAmount(null)->shouldBe($this->getWrappedObject());
    }

    public function it_should_pass_validation_when_foreign_retailer_amount_is_not_set()
    {
        $this->setForeignRetailerValidationParameters('10.00', null);

        $this->shouldNotThrow()->during('publicValidate');
    }

    public function it_should_pass_validation_when_foreign_retailer_amount_one_minor_unit_below_amount()
    {
        $this->setForeignRetailerValidationParameters('10.00', '9.99');

        $this->shouldNotThrow()->during('publicValidate');
        $this->getStructure()->shouldHaveKeyWithValue('foreign_retailer_transaction_amount', '999');
    }

    public function it_should_pass_validation_when_foreign_retailer_amount_equals_amount()
    {
        $this->setForeignRetailerValidationParameters('10.00', '10.00');

        $this->shouldNotThrow()->during('publicValidate');
        $this->getStructure()->shouldHaveKeyWithValue('foreign_retailer_transaction_amount', '1000');
    }

    public function it_should_fail_validation_when_foreign_retailer_amount_one_minor_unit_above_amount()
    {
        $this->setForeignRetailerValidationParameters('10.00', '10.01');

        $this->shouldThrow(
            new ErrorParameter('foreign_retailer_transaction_amount must not exceed the transaction amount.')
        )->during('publicValidate');
    }

    public function it_should_fail_validation_when_foreign_retailer_amount_is_zero()
    {
        $this->setForeignRetailerValidationParameters('10.00', '0');

        $this->shouldThrow(
            new ErrorParameter('foreign_retailer_transaction_amount must be greater than zero.')
        )->during('publicValidate');
    }

    public function it_should_fail_validation_with_greater_than_zero_when_both_amounts_are_zero()
    {
        $this->setForeignRetailerValidationParameters('0', '0');

        $this->shouldThrow(
            new ErrorParameter('foreign_retailer_transaction_amount must be greater than zero.')
        )->during('publicValidate');
    }

    public function it_should_fail_validation_with_exceed_when_amount_is_zero_and_foreign_amount_positive()
    {
        $this->setForeignRetailerValidationParameters('0', '0.01');

        $this->shouldThrow(
            new ErrorParameter('foreign_retailer_transaction_amount must not exceed the transaction amount.')
        )->during('publicValidate');
    }

    public function it_should_fail_validation_when_foreign_retailer_amount_exceeds_currency_exponent()
    {
        $this->setForeignRetailerValidationParameters('10.00', '10.555');

        $this->shouldThrow(
            new InvalidArgument('Currency EUR exponent 2 does not match the given amount 10.555')
        )->during('publicValidate');
    }

    public function it_should_convert_foreign_retailer_amount_for_exponent_zero_currency()
    {
        $this->setForeignRetailerValidationParameters('1050', '1050', 'JPY');

        $this->shouldNotThrow()->during('publicValidate');
        $this->getStructure()->shouldHaveKeyWithValue('foreign_retailer_transaction_amount', '1050');
    }

    public function it_should_convert_foreign_retailer_amount_for_exponent_three_currency()
    {
        $this->setForeignRetailerValidationParameters('10.500', '5.125', 'KWD');

        $this->shouldNotThrow()->during('publicValidate');
        $this->getStructure()->shouldHaveKeyWithValue('foreign_retailer_transaction_amount', '5125');
    }

    public function it_should_have_null_amount_in_structure_when_unset()
    {
        $this->setForeignRetailerValidationParameters('10.00', null);

        $this->getStructure()->shouldHaveKeyWithValue('foreign_retailer_transaction_amount', null);
    }

    /**
     * Indicator F with the given transaction and foreign retailer amounts
     *
     * @param string      $amount
     * @param string|null $foreignAmount
     * @param string      $currency
     *
     * @return void
     */
    private function setForeignRetailerValidationParameters($amount, $foreignAmount, $currency = 'EUR')
    {
        $this->setCurrency($currency);
        $this->setAmount($amount);
        $this->setForeignRetailerIndicator('F');
        $this->setForeignRetailerTransactionAmount($foreignAmount);
    }
}

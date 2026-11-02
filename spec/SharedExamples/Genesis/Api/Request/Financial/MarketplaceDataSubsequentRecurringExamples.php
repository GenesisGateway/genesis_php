<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\MarketplaceData\ForeignRetailerIndicators;
use Genesis\Api\Constants\Transaction\Parameters\Recurring\Types;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use spec\SharedExamples\Faker;

/**
 * Trait MarketplaceDataSubsequentRecurringExamples
 *
 * Marketplace Data validation on the recurring_type = subsequent path (Authorize, Sale)
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait MarketplaceDataSubsequentRecurringExamples
{
    public function it_should_fail_marketplace_subsequent_when_only_foreign_retailer_amount_set()
    {
        $this->setMarketplaceSubsequentRequestParameters();
        $this->setCurrency('EUR');
        $this->setForeignRetailerTransactionAmount('5.00');

        $this->shouldThrow(
            new ErrorParameter(
                'foreign_retailer_indicator is required when foreign_retailer_transaction_amount is provided.'
            )
        )->during('getDocument');
    }

    public function it_should_fail_marketplace_subsequent_when_foreign_retailer_amount_exceeds_amount()
    {
        $this->setMarketplaceSubsequentRequestParameters();
        $this->setCurrency('EUR');
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('10.01');

        $this->shouldThrow(
            new ErrorParameter('foreign_retailer_transaction_amount must not exceed the transaction amount.')
        )->during('getDocument');
    }

    public function it_should_fail_marketplace_subsequent_without_currency_when_foreign_retailer_amount_exceeds_amount()
    {
        $this->setMarketplaceSubsequentRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('10.01');

        $this->shouldThrow(
            new ErrorParameter('foreign_retailer_transaction_amount must not exceed the transaction amount.')
        )->during('getDocument');
    }

    public function it_should_not_fail_marketplace_subsequent_without_currency_when_foreign_retailer_amount_equals_amount()
    {
        $this->setMarketplaceSubsequentRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('10.00');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_marketplace_subsequent_without_currency_with_exponent_notation_amount()
    {
        $this->setMarketplaceSubsequentRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('1e2');

        $this->shouldThrow(
            new InvalidArgument(
                'Unsupported value 1e2 for foreign retailer amount validation. ' .
                'amount and foreign_retailer_transaction_amount must use decimal notation, for example 10.50.'
            )
        )->during('getDocument');
    }

    /**
     * Minimal valid subsequent recurring request without currency, transaction amount 10.00
     *
     * @return void
     */
    private function setMarketplaceSubsequentRequestParameters()
    {
        $faker = Faker::getInstance();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount('10.00');
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setRecurringType(Types::SUBSEQUENT);
        $this->setReferenceId('transaction-reference-id');
    }
}

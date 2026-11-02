<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\Funding\IdentifierTypes;
use Genesis\Api\Constants\Transaction\Parameters\MarketplaceData\ForeignRetailerIndicators;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait MarketplaceDataAttributesExamples
 *
 * Shared examples for requests composing MarketplaceDataAttributes.
 * Transaction amount is 10.00 EUR, foreign retailer amount 5.00 EUR (500 minor units)
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait MarketplaceDataAttributesExamples
{
    public function it_should_not_contain_marketplace_data_when_foreign_retailer_values_not_set()
    {
        $this->setMarketplaceDataRequestParameters();

        $this->getDocument()->shouldNotContain('marketplace_data');
        $this->getDocument()->shouldNotContain('foreign_retailer_indicator');
        $this->getDocument()->shouldNotContain('foreign_retailer_transaction_amount');
    }

    public function it_should_contain_marketplace_data_with_foreign_retailer_indicator_only()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);

        $this->getDocument()->shouldMatch(
            '/<marketplace_data>\s*<foreign_retailer_indicator>F<\/foreign_retailer_indicator>\s*<\/marketplace_data>/'
        );
        $this->getDocument()->shouldNotContain('foreign_retailer_transaction_amount');
    }

    public function it_should_fail_when_marketplace_foreign_retailer_amount_set_without_indicator()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerTransactionAmount('5.00');

        $this->shouldThrow(
            new ErrorParameter(
                'foreign_retailer_indicator is required when foreign_retailer_transaction_amount is provided.'
            )
        )->during('getDocument');
    }

    public function it_should_contain_marketplace_data_with_foreign_retailer_indicator_and_amount()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('5.00');

        $this->getDocument()->shouldMatch(
            '/<marketplace_data>\s*' .
            '<foreign_retailer_indicator>F<\/foreign_retailer_indicator>\s*' .
            '<foreign_retailer_transaction_amount>500<\/foreign_retailer_transaction_amount>\s*' .
            '<\/marketplace_data>/'
        );
    }

    public function it_should_place_marketplace_data_directly_before_funding()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setFundingIdentifierType(IdentifierTypes::PERSON_TO_PERSON);

        $this->getDocument()->shouldMatch('/<\/marketplace_data>\s*<funding>/');
    }

    public function it_should_fail_when_marketplace_foreign_retailer_indicator_invalid()
    {
        $this->setMarketplaceDataRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setForeignRetailerIndicator', ['X']);
    }

    public function it_should_fail_when_marketplace_foreign_retailer_amount_exceeds_transaction_amount()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('10.01');

        $this->shouldThrow(
            new ErrorParameter(
                'foreign_retailer_transaction_amount must not exceed the transaction amount.'
            )
        )->during('getDocument');
    }

    public function it_should_fail_with_currency_exponent_error_before_marketplace_indicator_error()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerTransactionAmount('10.555');

        $this->shouldThrow(
            new InvalidArgument('Currency EUR exponent 2 does not match the given amount 10.555')
        )->during('getDocument');
    }

    public function it_should_fail_with_required_currency_error_when_marketplace_foreign_retailer_amount_set()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('5.00');
        $this->setCurrency(null);

        $this->shouldThrow(
            new ErrorParameter('Empty (null) required parameter: currency')
        )->during('getDocument');
    }

    public function it_should_omit_marketplace_foreign_retailer_amount_when_cleared_with_null()
    {
        $this->setMarketplaceDataRequestParameters();
        $this->setForeignRetailerIndicator(ForeignRetailerIndicators::FOREIGN_RETAILER);
        $this->setForeignRetailerTransactionAmount('5.00');
        $this->setForeignRetailerTransactionAmount(null);

        $this->getDocument()->shouldContain('<foreign_retailer_indicator>F</foreign_retailer_indicator>');
        $this->getDocument()->shouldNotContain('foreign_retailer_transaction_amount');
    }

    /**
     * Valid request with a 10.00 EUR transaction amount
     *
     * @return void
     */
    private function setMarketplaceDataRequestParameters()
    {
        $this->setRequestParameters();
        $this->setCurrency('EUR');
        $this->setAmount('10.00');
    }
}

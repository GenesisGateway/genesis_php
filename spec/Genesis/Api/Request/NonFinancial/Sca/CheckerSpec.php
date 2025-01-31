<?php

namespace spec\Genesis\Api\Request\NonFinancial\Sca;

use Faker\Generator;
use Genesis\Api\Constants\Transaction\Parameters\ScaExemptions;
use Genesis\Api\Request\NonFinancial\Sca\Checker;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\MissingTerminalTokenExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

/**
 * Class CheckerSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Sca
 */
class CheckerSpec extends ObjectBehavior
{
    use MissingTerminalTokenExamples;
    use RequestExamples;

    /**
     * @property Generator $faker
     */

    const CARD_NUMBER_MIN_RANGE = 100000;
    const CARD_NUMBER_MAX_RANGE = 9999999999999999;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Checker::class);
    }

    public function it_can_build_structure()
    {
        $this->setDefaultRequestParameters();
        $this->getDocument()->shouldBeString();
    }

    public function it_should_use_the_json_builder()
    {
        $this->getApiConfig('format')->shouldBe(Builder::JSON);
    }

    public function it_should_have_default_required_keys_in_getDocument()
    {
        $this->setDefaultRequestParameters();

        $this->getDocument()->shouldContain('card_number');
        $this->getDocument()->shouldContain('transaction_amount');
        $this->getDocument()->shouldContain('transaction_currency');
    }

    public function it_should_contain_optional_parameters()
    {
        $this->setDefaultRequestParameters();

        $this->getDocument()->shouldContain('moto');
        $this->getDocument()->shouldContain('mit');
        $this->getDocument()->shouldContain('recurring_type');
        $this->getDocument()->shouldContain('transaction_exemption');
    }

    public function it_should_not_contain_optional_parameters_when_unset()
    {
        $this->setDefaultRequestParameters();

        $this->setMoto(false);
        $this->getDocument()->shouldNotContain('moto');

        $this->setMit(false);
        $this->getDocument()->shouldNotContain('mit');

        $this->setRecurringType(null);
        $this->getDocument()->shouldNotContain('recurring_type');

        $this->setTransactionExemption(null);
        $this->getDocument()->shouldNotContain('transaction_exemption');
    }

    public function it_should_fail_when_missing_card_number()
    {
        $this->setTransactionAmount($this->getFaker()->numberBetween(0, PHP_INT_MAX));
        $this->setTransactionCurrency($this->getRandomCurrency());
        $this->setOptionalRequestParameters();

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_card_number_be_casted_as_string()
    {
        $this->setCardNumber(
            $this->getFaker()->numberBetween(self::CARD_NUMBER_MIN_RANGE, self::CARD_NUMBER_MAX_RANGE)
        );
        $this->getCardNumber()->shouldBeString();
    }

    public function it_should_fail_with_non_digits_for_card_number()
    {
        $this->setCardNumber('ABCDEFGH');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_transaction_amount()
    {
        $this->setCardNumber($this->getFaker()->creditCardNumber);
        $this->setTransactionCurrency($this->getRandomCurrency());
        $this->setOptionalRequestParameters();

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_transaction_currency()
    {
        $this->setCardNumber($this->getFaker()->creditCardNumber);
        $this->setTransactionAmount(
            $this->getFaker()->numberBetween(0, PHP_INT_MAX)
        );
        $this->setOptionalRequestParameters();

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_card_number_less_than_six_digits()
    {
        $this->setDefaultRequestParameters();
        $this->setCardNumber(
            $this->getFaker()->numberBetween(0, self::CARD_NUMBER_MIN_RANGE - 1)
        );
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_card_number_more_than_16_digits()
    {
        $this->setDefaultRequestParameters();
        $this->setCardNumber(
            $this->getFaker()->numberBetween(self::CARD_NUMBER_MAX_RANGE + 1, PHP_INT_MAX)
        );
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_be_bool_moto_parameter()
    {
        $this->setDefaultRequestParameters();

        $this->setMoto(true);
        $this->getMoto()->shouldBeBool();

        $this->setMoto('1');
        $this->getMoto()->shouldBeBool();

        $this->setMoto(0);
        $this->getMoto()->shouldBeBool();

        $this->setMoto('false');
        $this->getMoto()->shouldBeBool();

        $this->setMoto(null);
        $this->getMoto()->shouldBeBool();
    }

    public function it_should_be_bool_mit_parameter()
    {
        $this->setDefaultRequestparameters();

        $this->setMit(true);
        $this->getMit()->shouldBeBool();

        $this->setMit('1');
        $this->getMit()->shouldBeBool();

        $this->setMit(0);
        $this->getMit()->shouldBeBool();

        $this->setMit(null);
        $this->getMit()->shouldBeBool();
    }

    public function it_should_not_fail_with_correct_exemption()
    {
        $this->shouldNotThrow()->duringSetTransactionExemption($this->getRandomExemption());
    }

    public function it_should_fail_when_exemption_is_not_valid()
    {
        $this->shouldThrow()->duringSetTansactionExemption('tttt');
    }

    public function it_should_return_null_when_unset_exemption()
    {
        $this->setDefaultRequestParameters();
        $this->setTransactionExemption(null);

        $this->getTransactionExemption()->shouldBeNull();
    }

    public function it_should_fail_with_invalid_transaction_amount()
    {
        $this->setDefaultRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setTransactionAmount', ['-23.45']);
        $this->shouldThrow(InvalidArgument::class)->during('setTransactionAmount', ['23,45']);
    }

    public function it_should_build_proper_url()
    {
        Config::setToken('123456');
        Config::setEndpoint('emp');
        Config::setEnvironment('staging');
        $this->setRequestParameters();
        $this->getDocument();

        $this->getApiConfig('url')->shouldBe('https://staging.gate.emerchantpay.net:443/v1/sca/checker/123456/');
    }

    public function it_should_throw_with_invalid_recurring_type()
    {
        $this->setRequestParameters();
        $this->setRecurringType('invalid');

        $this->shouldThrow(ErrorParameter::class)->duringGetDocument();
    }

    /**
     * Helper Methods
     */

    /**
     * @return Generator
     */
    protected function getFaker()
    {
        return Faker::getInstance();
    }

    protected function setDefaultRequestParameters()
    {
        $this->setRequiredRequestParameters();
        $this->setOptionalRequestParameters();
    }

    protected function setRequiredRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setCardNumber(
            $faker->numberBetween(self::CARD_NUMBER_MIN_RANGE, self::CARD_NUMBER_MAX_RANGE)
        );

        $this->setTransactionAmount(
            $faker->numberBetween(0, PHP_INT_MAX)
        );
        $this->setTransactionCurrency($this->getRandomCurrency());
    }

    protected function setOptionalRequestParameters()
    {
        $this->setMoto(true);
        $this->setMit(true);
        $this->setRecurringType('initial');
        $this->setTransactionExemption($this->getRandomExemption());
    }

    protected function getRandomCurrency()
    {
        $currencies = Currency::getList();

        return $currencies[array_rand($currencies)];
    }

    protected function getRandomExemption()
    {
        $exemptions = ScaExemptions::getAll();

        return $exemptions[array_rand($exemptions)];
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();
    }
}

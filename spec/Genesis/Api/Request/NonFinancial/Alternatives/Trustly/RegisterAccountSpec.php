<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\Trustly;

use Genesis\Api\Constants\NonFinancial\Alternatives\Trustly\ClearingHouses;
use Genesis\Api\Request\NonFinancial\Alternatives\Trustly\RegisterAccount;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\MissingTerminalTokenExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

/**
 * Class RegisterAccountSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\Trustly
 */
class RegisterAccountSpec extends ObjectBehavior
{
    use MissingTerminalTokenExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterAccount::class);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'first_name',
            'last_name',
            'birth_date',
            'user_id',
            'clearing_house',
            'account_number',
            'bank_number'
        ]);
    }

    public function it_should_not_fail_with_empty_bank_number()
    {
        $this->setRequestParameters();
        $this->setBankNumber('');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_invalid_clearing_house()
    {
        $this->setRequestParameters();
        $this->setClearingHouse('invalid_clearing_house');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setFirstName($faker->firstName);
        $this->setLastName($faker->lastName);
        $this->setBirthDate($faker->date());
        $this->setUserId($faker->numerify());
        $this->setClearingHouse($faker->randomElement(ClearingHouses::getAll()));
        $this->setAccountNumber($faker->numerify());
        $this->setBankNumber($faker->numerify());
    }
}

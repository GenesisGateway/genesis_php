<?php

namespace spec\Genesis\Api\Validators\Request;

use Genesis\Api\Validators\Request\RegexValidator;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\Exception;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\RequestStub;
use spec\SharedExamples\Faker;

class RegexValidatorSpec extends ObjectBehavior
{
    private $request;

    public function __construct()
    {
        $this->request = new RequestStub();
    }

    public function let()
    {
        $this->beConstructedWith(RegexValidator::PATTERN_CREDIT_CARD_NUMBER, 'Error message');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegexValidator::class);
    }

    public function it_should_validate_null_values()
    {
        $this->request->setField(null);

        $this->shouldThrow(InvalidArgument::class)->duringRun($this->request, 'field');
    }

    public function it_should_validate_non_existing_fields()
    {
        $this->shouldThrow(ErrorParameter::class)->duringRun($this->request, 'invalid_field');
    }

    public function it_should_validate_field_with_valid_value()
    {
        $this->request->setField(Faker::getInstance()->creditCardNumber);

        $this->shouldNotThrow()->duringRun($this->request, 'field');
    }

    public function it_should_validate_field_with_invalid_value()
    {
        $this->request->setField('invalid_card_number_value');

        $this->shouldThrow(InvalidArgument::class)->duringRun($this->request, 'field');
    }
}

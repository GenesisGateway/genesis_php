<?php

namespace spec\Genesis\Api\Traits\Validations\Request;

use Genesis\Api\Validators\Request\RegexValidator;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Validations\Request\ValidationsStub;
use spec\SharedExamples\Faker;


class ValidationsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ValidationsStub::class);
    }

    public function it_should_not_throw_when_required_fields_are_set()
    {
        $this->unsetTestVars();

        $faker = Faker::getInstance();

        $this->setRequiredFields([
            'test_field_1',
            'test_field_2',
            'test_field_3'
        ]);

        $this->test_field_1 = $faker->buildingNumber;
        $this->test_field_2 = $faker->numberBetween();
        $this->test_field_3 = $faker->word;

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_required_fields_are_not_set()
    {
        $this->unsetTestVars();

        $faker = Faker::getInstance();

        $this->setRequiredFields([
            'test_field_1',
            'test_field_2',
            'test_field_3'
        ]);

        $this->test_field_1 = $faker->buildingNumber;
        $this->test_field_2 = $faker->numberBetween();


        $this->shouldThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_required_fields_values_are_set()
    {
        $this->unsetTestVars();

        $this->setRequiredFieldsValues(
            [
                'test_field_1' => ['value_1', 'value_2']
            ]
        );

        $this->test_field_1 = 'value_1';

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_required_fields_values_are_set_with_regexp()
    {
        $this->unsetTestVars();

        $this->setRequiredFieldsValues(
            [
                'test_field_1' => ['value_1', new RegexValidator('/\d+/')]
            ]
        );

        $this->test_field_1 = 10;

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_required_fields_values_missing()
    {
        $this->unsetTestVars();

        $this->setRequiredFieldsValues(
            [
                'test_field_1' => ['value_1', 'value_2']
            ]
        );

        $this->test_field_1 = "missing_value";

        $this->shouldThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_required_fields_groups_are_set()
    {
        $this->unsetTestVars();

        $this->setValidateGroupRequirements(
            [
                'test_group_1'  => ['test_field_1', 'test_field_2', 'test_field_3'],
            ]
        );

        $this->test_group_1 = 'group';
        $this->test_field_1 = 'value_1';

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_none_of_required_field_group_is_set()
    {
        $this->unsetTestVars();

        $this->setValidateGroupRequirements(
            [
                'test_group_1'  => ['test_field_1', 'test_field_2', 'test_field_3'],
            ]
        );

        $this->test_group_1 = 'group';

        $this->shouldThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_required_fields_conditional_are_set()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalRequirements(
            [
                'test_field_1' => ['test_field_2'],
                'test_field_2' => ['test_field_1', 'test_field_3']

            ]
        );

        $this->test_field_1 = 'value_1';
        $this->test_field_2 = 'value_2';
        $this->test_field_3 = 'value_3';

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_one_of_required_field_conditional_is_not_set()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalRequirements(
            [
                'test_field_1' => ['test_field_2'],
                'test_field_2' => ['test_field_1', 'test_field_3']

            ]
        );

        $this->test_field_1 = 'value_1';
        $this->test_field_2 = 'value_2';

        $this->shouldThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_all_required_conditional_fields_or_are_set()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalFieldsOr(
            [
                'test_field_1',
                'test_field_2'
            ]
        );

        $this->test_field_1 = 'value_1';
        $this->test_field_2 = 'value_2';

        $this->shouldThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_none_of_required_conditional_fields_or_is_set()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalFieldsOr(
            [
                'test_field_1',
                'test_field_2'
            ]
        );

        $this->shouldThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_one_of_required_conditional_fields_or_is_set()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalFieldsOr(
            [
                'test_field_1',
                'test_field_2'
            ]
        );

        $this->test_field_2 = 'value_2';

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_required_value_conditional_is_set_with_valid_array()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalValuesRequirements([
            'parent_field' => [
                'field_value' => [
                    ['test_field_1' =>  [1, 2, 3, 4]]
                ]
            ]
        ]);

        $this->parent_field = "field_value";
        $this->test_field_1 = 1;

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_required_value_conditional_is_set_with_value()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalValuesRequirements([
            'parent_field' => [
                'field_value' => [
                    ['test_field_1' =>  'test_value']
                ]
            ]
        ]);

        $this->parent_field = 'field_value';
        $this->test_field_1 = 'test_value';

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_not_throw_when_required_values_conditional_are_set_with_valid_regexp()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalValuesRequirements([

            'parent_field' => [
                'field_value' => [
                    ['test_field_1' => new RegexValidator('/^.+@.+$/')]
                ]
            ]

        ]);

        $this->parent_field = "field_value";
        $this->test_field_1 = 'valid@regexp';

        $this->shouldNotThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_required_values_conditional_are_set_with_not_valid_regexp()
    {
        $this->unsetTestVars();

        $this->setValidateConditionalValuesRequirements([
            'parent_field' => [
                'field_value' => [
                    ['test_field_1' => new RegexValidator('/^.+@.+$/')]
                ]
            ]
        ]);

        $this->parent_field = 'field_value';
        $this->test_field_1 = 'not valid regexp';

        $this->shouldThrow(ErrorParameter::class)->during(
            'publicValidate'
        );
    }

    public function it_should_throw_when_missing_method()
    {
        $this->unsetTestVars();

        $this->setRequiredFields(
            [
                'test_field_1',
                'test_field_2'
            ]
        );

        $this->test_field_1 = 'value1';
        $this->test_field_2 = 'value2';

        $test_invoker = [
                'test_property' => 'test_method'
        ];

        $this->test_property = 'value';
        $this->test_method = '';

        $this->setValidations($test_invoker);

        $this->shouldThrow('\Genesis\Exceptions\InvalidClassMethod')->during(
            'publicValidate'
        );
    }

    public function it_should_return_false_without_defined_allowed_zero_amount_method()
    {
        $this->getHasAllowedEmptyFields()->shouldBe(false);
        $this->getIsNotNullAndEmptyValueAllowed('amount', '10')->shouldBe(false);
    }

    public function unsetTestVars()
    {
        unset($this->test_field_1);
        unset($this->test_field_2);
        unset($this->test_field_3);
    }
}

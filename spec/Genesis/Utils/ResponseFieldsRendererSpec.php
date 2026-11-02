<?php

namespace spec\Genesis\Utils;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;

class ResponseFieldsRendererSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['id', 'billingStatement', 'status', 'summary', 'details']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\ResponseFieldsRenderer');
    }

    public function it_should_validate_a_flat_selection()
    {
        $this->shouldNotThrow()->during('validate', [['id', 'billingStatement']]);
    }

    public function it_should_validate_a_nested_selection_by_top_level_key()
    {
        $this->shouldNotThrow()->during(
            'validate',
            [['billingStatement', 'details' => ['discountFees' => ['subtotalCount']]]]
        );
    }

    public function it_should_throw_when_a_top_level_field_is_not_allowed()
    {
        $this->shouldThrow(InvalidArgument::class)->during('validate', [['unknownField']]);
    }

    public function it_should_throw_when_a_nested_top_level_key_is_not_allowed()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'validate',
            [['unknownComplex' => ['child']]]
        );
    }

    public function it_should_not_validate_nested_field_names()
    {
        // 'details' is allowed at the top level; nested names are not checked
        $this->shouldNotThrow()->during(
            'validate',
            [['details' => ['anyMadeUpNestedField']]]
        );
    }

    public function it_should_throw_when_the_value_is_not_an_array()
    {
        $this->shouldThrow(InvalidArgument::class)->during('validate', ['not_an_array']);
    }

    public function it_should_render_a_flat_selection()
    {
        $this->render(['id', 'billingStatement'])
            ->shouldReturn('id billingStatement');
    }

    public function it_should_render_a_nested_selection()
    {
        $this->render(['billingStatement', 'details' => ['discountFees' => ['subtotalCount']]])
            ->shouldReturn('billingStatement details { discountFees { subtotalCount } }');
    }

    public function it_should_render_deeply_nested_selections()
    {
        $this->render(['details' => ['a' => ['b' => ['c']]]])
            ->shouldReturn('details { a { b { c } } }');
    }

    public function it_should_throw_on_empty_nested_selection()
    {
        $this->shouldThrow(InvalidArgument::class)->during('render', [['details' => []]]);
    }
}

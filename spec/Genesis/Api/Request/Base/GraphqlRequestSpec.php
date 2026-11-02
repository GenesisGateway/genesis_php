<?php

namespace spec\Genesis\Api\Request\Base;

use Genesis\Api\Constants\Endpoints;
use Genesis\Config;
use spec\Genesis\Api\Stubs\Base\Request\GraphqlRequestStub;

class GraphqlRequestSpec extends \PhpSpec\ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(GraphqlRequestStub::class);
    }

    public function it_should_set_version_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVersion',
            ['v1']
        );
    }

    public function it_should_fail_if_version_is_invalid()
    {
        $this->shouldThrow()->during(
            'setVersion',
            ['v100']
        );
    }

    public function it_should_init_proper_configuration()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setVersion('v1');

        $this->getApiConfig('url')->shouldBe(
            "https://staging.api.emerchantpay.net:443/test/v1/graphql"
        );
    }

    public function it_should_have_proper_request_type()
    {
        $this->getRequestType()->shouldBe('json');
    }

    public function it_should_create_proper_graphql_element()
    {
        $this->publicGenerateGraphQLCode(
                ['element' => 'value', 'element2' => 'value2'],
                'test',
                ', ',
                '%s: %s'
            )->shouldBe('test: { element: value, element2: value2 }');
    }

    public function it_should_populate_proper_transaction_structure()
    {
        $this->getDocument()->shouldContain('query');
        $this->getDocument()->shouldContain('filter');
        $this->getDocument()->shouldContain('items');
    }

    public function it_should_format_plain_string_list()
    {
        $this->publicFormatArrayToGraphQLStringList(['A123', 'B456'])
            ->shouldBe('["A123","B456"]');
    }

    public function it_should_return_empty_string_for_empty_string_list()
    {
        $this->publicFormatArrayToGraphQLStringList([])
            ->shouldBe('');
    }

    public function it_should_escape_double_quotes_in_string_list()
    {
        $this->publicFormatArrayToGraphQLStringList(['A"B'])
            ->shouldBe('["A\\"B"]');
    }

    public function it_should_escape_backslashes_in_string_list()
    {
        $this->publicFormatArrayToGraphQLStringList(['A\\B'])
            ->shouldBe('["A\\\\B"]');
    }

    public function it_should_escape_backslash_before_quote_in_string_list()
    {
        $this->publicFormatArrayToGraphQLStringList(['A\\"B'])
            ->shouldBe('["A\\\\\\"B"]');
    }

    public function it_should_escape_newline_in_string_list()
    {
        // The element is double-quoted so it holds a real LF. The formatter escapes the element
        // through its existing escapeGraphQLString() call - A, \, n, B - then adds one pair of
        // unescaped double quotes and one pair of square brackets, so the expected single-quoted
        // '["A\\nB"]' is the 9 characters [, ", A, \, n, B, ", ].
        $this->publicFormatArrayToGraphQLStringList(["A\nB"])
            ->shouldBe('["A\\nB"]');
    }

    public function it_should_escape_newline()
    {
        // The input is double-quoted so it holds a real LF; the expectation is single-quoted
        // so 'A\\nB' is the four characters A, backslash, n, B.
        $escaped = $this->publicEscapeGraphQLString("A\nB");

        $escaped->shouldBe('A\\nB');
        $escaped->shouldNotContain("\n");
        $escaped->shouldParseBackTo("A\nB");
    }

    public function it_should_escape_carriage_return()
    {
        $escaped = $this->publicEscapeGraphQLString("A\rB");

        $escaped->shouldBe('A\\rB');
        $escaped->shouldNotContain("\r");
        $escaped->shouldParseBackTo("A\rB");
    }

    public function it_should_escape_tab()
    {
        $escaped = $this->publicEscapeGraphQLString("A\tB");

        $escaped->shouldBe('A\\tB');
        $escaped->shouldNotContain("\t");
        $escaped->shouldParseBackTo("A\tB");
    }

    public function it_should_escape_backspace()
    {
        // PHP has no \b escape sequence, so the backspace is written as "\x08";
        // the expected 'A\\bB' is the two-character GraphQL sequence \b between A and B.
        $escaped = $this->publicEscapeGraphQLString("A\x08B");

        $escaped->shouldBe('A\\bB');
        $escaped->shouldNotContain("\x08");
        $escaped->shouldParseBackTo("A\x08B");
    }

    public function it_should_escape_form_feed()
    {
        $escaped = $this->publicEscapeGraphQLString("A\fB");

        $escaped->shouldBe('A\\fB');
        $escaped->shouldNotContain("\f");
        $escaped->shouldParseBackTo("A\fB");
    }

    public function it_should_escape_backslash_quote_and_newline_together()
    {
        // Input is the 7 characters A, backslash, B, double quote, C, LF, D.
        // The Escape_Order replaces the backslash first, so the expected 10 characters are
        // A, \, \, B, \, ", C, \, n, D - one escape per input character, none applied twice.
        $escaped = $this->publicEscapeGraphQLString("A\\B\"C\nD");

        $escaped->shouldBe('A\\\\B\\"C\\nD');
        $escaped->shouldParseBackTo("A\\B\"C\nD");
    }

    public function it_should_not_confuse_backslash_n_with_a_newline()
    {
        // Input is the 2 characters backslash and the letter n, not a newline.
        // It escapes to the 3 characters \, \, n, whereas a real newline escapes to
        // the 2 characters \, n - so the two inputs must never share an output.
        $escaped = $this->publicEscapeGraphQLString('\\n');

        $escaped->shouldBe('\\\\n');
        $escaped->shouldNotBe('\\n');
    }

    public function it_should_double_a_run_of_backslashes()
    {
        // A run of N backslashes is seen only by the first pass, which doubles each one,
        // so 3 backslashes yield exactly 6. The A and B anchors make "exactly 6" checkable:
        // a run that grew or shrank would not match this expected value.
        $escaped = $this->publicEscapeGraphQLString('A' . str_repeat('\\', 3) . 'B');

        $escaped->shouldBe('A' . str_repeat('\\', 6) . 'B');
        $escaped->shouldParseBackTo('A' . str_repeat('\\', 3) . 'B');
    }

    public function it_should_escape_backslash_before_newline_leaving_the_sequence_intact()
    {
        // Input is the 4 characters A, backslash, LF, B. The backslash pass doubles the input
        // backslash and the newline pass then adds the \n sequence, so the output carries
        // 3 consecutive backslashes then n: the doubled input backslash plus the sequence's
        // own backslash, which stays single because the backslash pass had already finished.
        $escaped = $this->publicEscapeGraphQLString("A\\\nB");

        $escaped->shouldBe('A' . str_repeat('\\', 3) . 'nB');
        $escaped->shouldParseBackTo("A\\\nB");
    }

    public function it_should_return_plain_value_unchanged()
    {
        // A Plain_Value holds none of the seven escaped characters, so escaping is the identity
        // on it. This is the regression guard for byte-identical request text (Requirement 3.9).
        $this->publicEscapeGraphQLString('A123-B456 x')
            ->shouldBe('A123-B456 x');
    }

    public function it_should_escape_all_newline_occurrences()
    {
        // Input is the 3 characters LF, A, LF - so one example covers both the multiplicity case
        // and the leading and trailing control-character positions. The expected '\\nA\\n' is the
        // 6 characters \, n, A, \, n.
        $escaped = $this->publicEscapeGraphQLString("\nA\n");

        $escaped->shouldBe('\\nA\\n');
        $escaped->shouldNotContain("\n");
        $escaped->shouldParseBackTo("\nA\n");
    }

    public function it_should_cast_non_string_value()
    {
        // The (string) cast is pre-existing behavior the completed escaping must preserve.
        $this->publicEscapeGraphQLString(12345)
            ->shouldBe('12345');
    }

    public function it_should_not_duplicate_flat_response_fields()
    {
        $this->addResponseField('response_field');
        $this->addResponseField('response_field');
        $this->addResponseField('other_field');

        $this->getResponseFields()->shouldBe('response_field other_field');
    }

    public function it_should_set_and_render_flat_and_nested_response_fields()
    {
        $this->setResponseFields(['response_field', 'other_field' => ['child']]);

        $this->getResponseFields()->shouldBe('response_field other_field { child }');
    }

    public function getMatchers(): array
    {
        return [
            // GraphQL's EscapedCharacter set is identical to JSON's two-character escape set,
            // and ext-json is a hard requirement, so json_decode() is a faithful parser oracle.
            // The comparison is strict so a null from a failed decode never equals an expectation.
            'parseBackTo' => function ($subject, $expected) {
                return json_decode('"' . $subject . '"', true) === $expected;
            }
        ];
    }
}

<?php

namespace spec\Genesis\Parsers;

use PhpSpec\ObjectBehavior;

class JSONSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Parsers\JSON');
    }

    public function it_should_parse_response()
    {
        $json = file_get_contents('spec/fixtures/JSON/kyc_success_response.json');

        $this->parseDocument($json);

        $this->getObject()->code->shouldBe(0);
        $this->getObject()->technical_message->shouldBe('Successful Response');
        $this->getObject()->details->shouldBeArray();
        $this->getObject()->details[0]->risk_score->shouldBe(98);
    }
}

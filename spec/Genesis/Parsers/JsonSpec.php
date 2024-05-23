<?php

namespace spec\Genesis\Parsers;

use PhpSpec\ObjectBehavior;

class JsonSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Parsers\Json');
    }

    public function it_should_parse_response()
    {
        $json = file_get_contents('spec/Fixtures/Json/KycSuccessResponse.json');

        $this->parseDocument($json);

        $this->getObject()->code->shouldBe(0);
        $this->getObject()->technical_message->shouldBe('Successful Response');
        $this->getObject()->details->shouldBeArray();
        $this->getObject()->details[0]->risk_score->shouldBe(98);
    }

    public function it_should_parse_graphql_response()
    {
        $json = file_get_contents('spec/Fixtures/Json/BillingApiSuccessResponse.json');

        $this->parseDocument($json);

        $this->getObject()->data->billingTransactions->items->shouldBeArray();
        $this->getObject()->data->billingTransactions->items[0]->billingStatementId->shouldBe(10001);
        $this->getObject()->data->billingTransactions->paging->page->shouldBe(1);
    }
}

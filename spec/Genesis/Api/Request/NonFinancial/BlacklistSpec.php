<?php

namespace spec\Genesis\Api\Request\NonFinancial;

use Genesis\Api as API;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class BlacklistSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(API\Request\NonFinancial\Blacklist::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'card_number'
        ]);
    }

    public function it_should_not_append_the_token_to_the_endpoint_url()
    {
        Config::setToken('terminal-token');
        $this->getApiConfig('url')->shouldNotContain('terminal-token');
    }

    protected function setRequestParameters()
    {
        $this->setCardNumber($this->getFaker()->creditCardNumber);
    }
}

<?php

namespace spec\Genesis\API\Request\NonFinancial\Fx;

use Genesis\API\Request\NonFinancial\Fx\SearchRate;
use Genesis\Builder;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class SearchRateSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(SearchRate::class);
    }

    public function it_should_build_correct_url()
    {
        \Genesis\Config::setEndpoint(
            \Genesis\API\Constants\Endpoints::EMERCHANTPAY
        );
        $this->setTierId(88);

        $this->getApiConfig('url')
             ->shouldBe('https://staging.gate.emerchantpay.net:443/v1/fx/tiers/88/rates/search');
    }

    public function it_should_have_correct_request_method()
    {
        $this->getConfig()->shouldHaveKeyWithValue('type', 'POST');
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'source_currency',
            'target_currency'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTierId(88);
        $this->setSourceCurrency($faker->currencyCode);
        $this->setTargetCurrency($faker->currencyCode);
    }
}

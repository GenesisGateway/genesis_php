<?php

namespace spec\Genesis\Api\Request\NonFinancial\Fx;

use Genesis\Api\Request\NonFinancial\Fx\SearchRate;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

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
            \Genesis\Api\Constants\Endpoints::EMERCHANTPAY
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

    public function it_should_fail_with_missing_required_source_currency()
    {
        $this->setRequestParameters();
        $this->setSourceCurrency(null);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_missing_required_target_currency()
    {
        $this->setRequestParameters();
        $this->setTargetCurrency(null);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_target_and_source_currency_are_equal()
    {
        $this->setSourceCurrency('USD');
        $this->shouldThrow()->during('setTargetCurrency', ['USD']);
        $this->setTargetCurrency('EUR');
        $this->shouldThrow()->during('setSourceCurrency', ['EUR']);
    }

    protected function setRequestParameters()
    {
        $currenciesPair = $this->getCurrencyPair();

        $this->setTierId(88);
        $this->setSourceCurrency($currenciesPair[0]);
        $this->setTargetCurrency($currenciesPair[1]);
    }

    private function getCurrencyPair()
    {
        $source = Currency::getRandomCurrency();
        $target = Currency::getRandomCurrency();

        if ($source === $target) {
            return $this->getCurrencyPair();
        }

        return [$source, $target];
    }
}

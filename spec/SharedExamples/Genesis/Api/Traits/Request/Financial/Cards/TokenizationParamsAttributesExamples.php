<?php

namespace spec\SharedExamples\Genesis\Api\Traits\Request\Financial\Cards;

use PhpSpec\ObjectBehavior;

trait TokenizationParamsAttributesExamples
{
    public function it_without_tavv()
    {
        $this->setRequestParameters();
        $this->setTokenizationTavv(null);
        $this->setTokenizationEci(null);
        $this->getDocument()->shouldNotContain('<tokenization_params>' . PHP_EOL . '    <tavv>');
    }

    public function it_without_eci()
    {
        $this->setRequestParameters();
        $this->setTokenizationTavv(null);
        $this->setTokenizationEci(null);
        $this->getDocument()->shouldNotContain('<tokenization_params>' . PHP_EOL . '    <eci>');
    }

    public function it_should_set_tavv()
    {
        $tavv = $this->getFaker()->numberBetween(1, 999999);
        $this->setRequestParameters();
        $this->setTokenizationTavv($tavv);
        $this->setTokenizationEci(null);
        $this->getDocument()->shouldContain('<tokenization_params>' . PHP_EOL . "    <tavv>$tavv</tavv>");
    }

    public function it_should_set_eci()
    {
        $eci = $this->getFaker()->numberBetween(1, 99);
        $this->setRequestParameters();
        $this->setTokenizationEci($eci);
        $this->setTokenizationTavv(null);
        $this->getDocument()->shouldContain('<tokenization_params>' . PHP_EOL . "    <eci>$eci</eci>");
    }
}

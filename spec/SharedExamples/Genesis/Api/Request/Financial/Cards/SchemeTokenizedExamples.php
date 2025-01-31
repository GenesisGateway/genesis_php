<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Cards;

trait SchemeTokenizedExamples
{
    public function it_should_set_scheme_tokenized()
    {
        $this->setRequestParameters();
        $this->setSchemeTokenized(true);
        $this->getDocument()->shouldContain("<scheme_tokenized>true</scheme_tokenized>");
    }
}

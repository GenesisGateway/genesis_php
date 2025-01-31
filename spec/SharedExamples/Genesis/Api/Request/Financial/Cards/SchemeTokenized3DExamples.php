<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Cards;

trait SchemeTokenized3DExamples
{
    use SchemeTokenizedExamples;

    public function it_works_without_directory_server_id_when_scheme_tokenized_is_set()
    {
        $this->setRequestParameters();
        $this->setSchemeTokenized(true);
        $this->setMpiParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_throw_without_directory_server_id_when_scheme_tokenized_not_set()
    {
        $this->setRequestParameters();
        $this->setMpiParameters();
        $this->shouldThrow()->during('getDocument');
    }

    private function setMpiParameters()
    {
        $this->setMpiEci('05');
        $this->setMpiCavv('MDAwMDAwMDAwMDAxMTA2Njk5NFg=');
        $this->setMpiProtocolVersion('2');
        $this->setMpiProtocolSubVersion('2');
        $this->setMpiDirectoryServerId(null);
    }
}

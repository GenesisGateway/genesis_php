<?php

namespace spec\SharedExamples\Genesis\API\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ExternallyProcessed;

/**
 * Trait ExternallyProcessedSharedExample
 * @package spec\SharedExamples\Genesis\API\Request\NonFinancial
 */
trait ExternallyProcessedSharedExample
{

    protected function setExternallyProcessedParameters()
    {
        $this->setExternallyProcessed($this->getRandomExternallyProcessed());
    }

    /**
     * Random Externally Processed attribute value
     *
     * @return string
     */
    protected function getRandomExternallyProcessed()
    {
        $externallyProcessed = ExternallyProcessed::getAll();

        return $externallyProcessed[array_rand($externallyProcessed)];
    }
}

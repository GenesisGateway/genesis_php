<?php

namespace spec\SharedExamples\Genesis\API\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ProcessingTypes;

trait ProcessingTypeSharedExample
{

    protected function setProcessingTypeParameters()
    {
        $this->setProcessingType($this->getRandomProcessingType());
    }

    /**
     * Random Processing Type
     *
     * @return string
     */
    protected function getRandomProcessingType()
    {
        $processingType = ProcessingTypes::getAll();

        return $processingType[array_rand($processingType)];
    }
}

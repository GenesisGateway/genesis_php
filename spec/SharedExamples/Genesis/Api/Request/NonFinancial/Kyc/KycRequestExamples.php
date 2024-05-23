<?php

namespace spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc;

use Genesis\Api\Constants\Endpoints;
use Genesis\Config;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait KycRequestExamples
 * @package spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc
 */
trait KycRequestExamples
{
    /**
     * @throws InvalidArgument|EnvironmentNotSet
     */
    public function it_should_have_kyc_subdomain()
    {
        Config::setEndpoint(
            Endpoints::EMERCHANTPAY
        );

        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1'
        );

    }
}
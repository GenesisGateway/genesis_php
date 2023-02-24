<?php

namespace spec\SharedExamples\Genesis\API\Request\NonFinancial\KYC;

use Genesis\API\Constants\Endpoints;
use Genesis\API\Constants\Environments;
use Genesis\Config;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait KYCRequestExamples
 * @package spec\SharedExamples\Genesis\API\Request\NonFinancial\KYC
 */
trait KYCRequestExamples
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
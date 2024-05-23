<?php

namespace spec\SharedExamples\Genesis\Network;

use Genesis\Api\Request;
use Genesis\Config;

/**
 * Trait HttpStatusExample
 *
 * @package spec\SharedExamples\Genesis\Network
 */
trait HttpStatusExample
{
    public function it_should_not_fail_with_invalid_credentials_when_connect_to_staging()
    {
        $this->getWrappedObject()->is_401_status = true;

        Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
        Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        $this->sendRemoteConnection(
            sprintf('https://%s%s', Config::getSubDomain('gateway'), Config::getEndpoint()),
            Request::AUTH_TYPE_BASIC,
            null,
            401
        );
    }

    public function it_should_not_fail_with_invalid_credentials_when_connect_to_production()
    {
        $this->getWrappedObject()->is_prod       = true;
        $this->getWrappedObject()->is_401_status = true;

        Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
        Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        $this->sendRemoteConnection(
            sprintf('https://%s%s', Config::getSubDomain('gateway'), Config::getEndpoint()),
            Request::AUTH_TYPE_BASIC,
            null,
            401
        );
    }

    public function it_should_not_fail_with_http_status_422_when_connect_to_graphql_staging()
    {
        $this->getWrappedObject()->is_422_status  = true;

        Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
        Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        $this->sendRemoteConnection(
            $this->getGraphqlServiceUrl('billing_transactions'),
            Request::AUTH_TYPE_TOKEN,
            Config::getBillingApiToken(),
            422
        );
    }

    public function it_should_not_fail_with_http_status_422_when_connect_to_graphql_production()
    {
        $this->getWrappedObject()->is_prod        = true;
        $this->getWrappedObject()->is_422_status  = true;

        Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
        Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        $this->sendRemoteConnection(
            $this->getGraphqlServiceUrl('billing_transactions'),
            Request::AUTH_TYPE_TOKEN,
            Config::getBillingApiToken(),
            422
        );
    }
}

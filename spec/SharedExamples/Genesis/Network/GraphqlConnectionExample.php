<?php

namespace spec\SharedExamples\Genesis\Network;

use Genesis\Api\Request;
use Genesis\Config;

/**
 * Trait GraphqlConnectionExample
 *
 * @package spec\SharedExamples\Genesis\Network
 */
trait GraphqlConnectionExample
{
    public function it_can_connect_to_staging_graphql_billing_api()
    {
        $this->getWrappedObject()->is_billing_api = true;
        $this->getWrappedObject()->is_prod        = false;

        Config::setBillingApiToken('password');
        Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
        Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        $this->sendRemoteConnection(
            $this->getGraphqlServiceUrl('billing_transactions'),
            Request::AUTH_TYPE_TOKEN,
            Config::getBillingApiToken()
        );
    }

    public function it_can_connect_to_production_graphql_billing_api()
    {
        $this->getWrappedObject()->is_billing_api = true;
        $this->getWrappedObject()->is_prod        = true;

        Config::setBillingApiToken('password');
        Config::setEnvironment(\Genesis\Api\Constants\Environments::PRODUCTION);
        Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        $this->sendRemoteConnection(
            $this->getGraphqlServiceUrl('billing_transactions'),
            Request::AUTH_TYPE_TOKEN,
            Config::getBillingApiToken()
        );
    }
}

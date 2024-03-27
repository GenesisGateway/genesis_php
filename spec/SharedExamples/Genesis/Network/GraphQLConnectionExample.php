<?php

namespace spec\SharedExamples\Genesis\Network;

use Genesis\API\Request;
use Genesis\Config;

/**
 * Trait GraphQLConnectionExample
 *
 * @package spec\SharedExamples\Genesis\Network
 */
trait GraphQLConnectionExample
{
    public function it_can_connect_to_staging_graphql_billing_api()
    {
        $this->getWrappedObject()->is_billing_api = true;
        $this->getWrappedObject()->is_prod        = false;

        Config::setEnvironment(
            \Genesis\API\Constants\Environments::STAGING
        );

        Config::setEndpoint(\Genesis\API\Constants\Endpoints::EMERCHANTPAY);

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

        Config::setEnvironment(
            \Genesis\API\Constants\Environments::PRODUCTION
        );

        $this->sendRemoteConnection(
            $this->getGraphqlServiceUrl('billing_transactions'),
            Request::AUTH_TYPE_TOKEN,
            Config::getBillingApiToken()
        );
    }
}
